<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ClientNotification;
use App\Models\Notification;

class NotificationService
{
    public function notifyClient(
        string $description,
        ?int $userId = null,
        ?int $companyId = null,
        ?int $lpkId = null,
        ?int $jobVacancyId = null,
        ?int $internshipId = null,
        ?int $trainingId = null,
        ?int $appId = null
    ): ClientNotification {
        return ClientNotification::create([
            'desc_notif' => $description,
            'app_id' => $appId,
            'jobvacancy_id' => $jobVacancyId,
            'internship_id' => $internshipId,
            'training_id' => $trainingId,
            'user_id' => $userId,
            'company_id' => $companyId,
            'lpk_id' => $lpkId,
            'status_mute' => '0',
            'status_read' => '0',
            'deleted_notif' => '0',
        ]);
    }

    public function notifyAdmin(
        string $description,
        int $subtype,
        array $refs = []
    ): Notification {
        return Notification::create([
            'desc_notif' => mb_substr($description, 0, 250),
            'user_id' => $refs['user_id'] ?? null,
            'company_id' => $refs['company_id'] ?? null,
            'lpk_id' => $refs['lpk_id'] ?? null,
            'jv_id' => $refs['jv_id'] ?? null,
            'train_id' => $refs['train_id'] ?? null,
            'in_id' => $refs['in_id'] ?? null,
            'cf_id' => $refs['cf_id'] ?? null,
            'ak1_id' => $refs['ak1_id'] ?? null,
            'dispute_id' => $refs['dispute_id'] ?? null,
            'status_reg' => $refs['status_reg'] ?? '0',
            'status_read' => '0',
            'subtype_notif' => $subtype,
        ]);
    }

    public function logActivity(int $userId, string $action): void
    {
        ActivityLog::create([
            'user_log' => $userId,
            'action' => mb_substr($action, 0, 128),
        ]);
    }
}
