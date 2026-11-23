<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

final class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'b', 'strong', 'i', 'em', 'u', 's', 'strike',
        'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'blockquote', 'pre', 'code', 'hr', 'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'a', 'span', 'div',
    ];

    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        // If plain text without tags, convert newlines cleanly
        if (strip_tags($html) === $html) {
            return nl2br(e($html));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $prev = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        $root = $dom->documentElement;
        if (!$root) {
            return e(strip_tags($html));
        }

        self::sanitizeNode($root);

        $output = '';
        foreach ($root->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return $output;
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math'], true)) {
                    $node->removeChild($child);
                    continue;
                }

                if (!in_array($tag, self::ALLOWED_TAGS, true)) {
                    self::sanitizeNode($child);
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                // Strip dangerous attributes
                $attrsToRemove = [];
                foreach ($child->attributes as $attr) {
                    $name = strtolower($attr->nodeName);
                    if ($tag === 'a' && $name === 'href') {
                        $val = trim($attr->nodeValue);
                        if (!preg_match('#^(https?://|mailto:|/)#i', $val)) {
                            $attrsToRemove[] = $attr->nodeName;
                        }
                    } elseif ($tag === 'a' && $name === 'target') {
                        if ($attr->nodeValue === '_blank') {
                            $child->setAttribute('rel', 'noopener noreferrer');
                        }
                    } else {
                        $attrsToRemove[] = $attr->nodeName;
                    }
                }

                foreach ($attrsToRemove as $attrName) {
                    $child->removeAttribute($attrName);
                }

                self::sanitizeNode($child);
            }
        }
    }
}
