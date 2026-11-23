<?php

namespace App\Support;

final class SidutaConstants
{
    // Role IDs (1..24 sesuai siduta.sql)
    public const SUPER_ADMIN = 1;
    public const ADMIN_REG = 2;
    public const ADMIN_PENTA = 3;
    public const ADMIN_LATTAS = 4;
    public const ADMIN_HUB_INDUSTRIAL = 5;
    public const ADMIN_PSP = 6;
    public const KADIS = 7;
    public const PENGANTAR_KERJA = 8;
    public const INSTRUKTUR_PELATIHAN = 9;
    public const INSTRUKTUR_PRODUKTIVITAS = 10;
    public const INSTRUKTUR_SERTIFIKASI = 11;
    public const MEDIATOR = 12;
    public const PERUSAHAAN = 13;
    public const ANGKATAN_KERJA = 14;
    public const LEMBAGA_PELATIHAN = 15;
    public const KABID_PENTA = 16;
    public const KABID_LATTAS = 17;
    public const KABID_PSP = 18;
    public const KABID_HI = 19;
    public const SEKRETARIS = 20;
    public const ADMIN_SEKRETARIAT = 21;
    public const VIEWER = 22;
    public const BPJS_KETENAGAKERJAAN = 23;
    public const BPJS_KESEHATAN = 24;

    // Certification process status
    public const SUBMITTED_CER = 1;
    public const ACCEPTED_CER_BY_ADMINLATAS = 2;
    public const ACCEPTED_CER_BY_INSCER = 3;
    public const ACCEPTED_CER_BY_KABIDLATAS = 4;
    public const APPROVED_CER = 5;
    public const REJECTED_CER = 99;

    // AK-1 process status
    public const AK1_SUBMITTED = 1;
    public const AK1_ACCEPTED_PENTA = 2;
    public const AK1_APPROVED = 3;
    public const AK1_DECLINED_PENGANTAR_KERJA = 98;
    public const AK1_DECLINED_PENTA = 99;

    // Registration step status
    public const STATUS_REG_DATADIRI = 0;
    public const STATUS_REG_SPESIALISASI = 1;
    public const STATUS_REG_PENDIDIKAN = 2;
    public const STATUS_REG_JSDONE = 3;

    public const STATUS_REG_DATAPERUSAHAAN = 0;
    public const STATUS_REG_COMDONE = 1;

    public const STATUS_REG_DATALPK = 0;
    public const STATUS_REG_LPKDONE = 1;
    public const STATUS_REG_UPLOADED = 2;
    public const STATUS_REG_APPROVED = 3;

    // User category
    public const CAT_JOBSEEKER = 0;
    public const CAT_LPK = 1;
    public const CAT_COMPANY = 2;

    // Dispute status
    public const DISPUTE_SEND_BY_USER = 0;
    public const DISPUTE_ACCEPTED_ADMIN_PSP = 1;
    public const DISPUTE_ACCEPTED_KABID = 2;
    public const DISPUTE_CLEARED_MEDIATOR = 3;
    public const DISPUTE_FINISHED_KABID = 4;
    public const DISPUTE_UNSOLVED = 99;

    // Publish status (Job Vacancy / Internship / Training)
    public const SUBMITTED = 0;
    public const PUBLISHED = 1;
    public const DECLINED = 2;
    public const CLOSED = 3;

    // Process status (Job Vacancy / Internship / Training approval flow)
    public const PROC_DRAFT_OR_PENDING = 0;
    public const PROC_SUBMITTED = 1;
    public const PROC_REVIEWED_OFFICER = 2;
    public const PROC_APPROVED_KABID = 3;
    public const PROC_DECLINED = 99;

    // Applicant apply status
    public const APPLY_PENDING = 0;
    public const APPLY_SHORTLISTED = 1;
    public const APPLY_ACCEPTED = 2;
    public const APPLY_REJECTED = 3;

    // Deleted flag
    public const DELETED = '1';
    public const NOT_DELETED = '0';

    // Token type
    public const TOKEN_REGISTER = 0;
    public const TOKEN_RESET = 1;

    // User files type
    public const FILE_CV_RESUME = 1;
    public const FILE_IJAZAH = 2;
    public const FILE_CERTIFICATE = 3;

    // Industrial relation service status (PP, PKWT, PKB)
    public const HI_SUBMITTED = 0;
    public const HI_VERIFIED_BPJS = 1;
    public const HI_ASSIGNED_MEDIATOR = 2;
    public const HI_APPROVED = 3;
    public const HI_DECLINED = 99;

    public static function adminHomeRouteByRole(int $roleId): string
    {
        return match ($roleId) {
            self::SUPER_ADMIN, self::KADIS, self::VIEWER, self::SEKRETARIS, self::ADMIN_SEKRETARIAT => 'adm.administrator',
            self::ADMIN_REG => 'adm.user.index',
            self::ADMIN_PENTA => 'adm.management.ak1.index',
            self::KABID_PENTA, self::PENGANTAR_KERJA => 'adm.management.job_vacancy.index',
            self::ADMIN_LATTAS, self::KABID_LATTAS, self::INSTRUKTUR_PRODUKTIVITAS => 'adm.management.internship.index',
            self::INSTRUKTUR_PELATIHAN => 'adm.management.training.index',
            self::INSTRUKTUR_SERTIFIKASI => 'adm.management.certification.index',
            self::ADMIN_PSP, self::KABID_PSP, self::MEDIATOR, self::KABID_HI => 'adm.management.dispute.index',
            self::ADMIN_HUB_INDUSTRIAL, self::BPJS_KETENAGAKERJAAN, self::BPJS_KESEHATAN => 'adm.management.pelayanan.index',
            default => 'adm.user.index',
        };
    }

    public static function ak1StatusLabel(int $status): array
    {
        return match ($status) {
            self::AK1_SUBMITTED => ['label' => 'Menunggu Persetujuan Admin Penta', 'badge' => 'info'],
            self::AK1_ACCEPTED_PENTA => ['label' => 'Diproses Pengantar Kerja', 'badge' => 'primary'],
            self::AK1_APPROVED => ['label' => 'Disetujui / Siap Cetak', 'badge' => 'success'],
            self::AK1_DECLINED_PENGANTAR_KERJA => ['label' => 'Ditolak oleh Pengantar Kerja', 'badge' => 'danger'],
            self::AK1_DECLINED_PENTA => ['label' => 'Ditolak oleh Admin Penta', 'badge' => 'danger'],
            default => ['label' => 'Draft / Proses', 'badge' => 'secondary'],
        };
    }

    public static function certificationStatusLabel(int $status): array
    {
        return match ($status) {
            self::SUBMITTED_CER => ['label' => 'Menunggu Admin LATTAS', 'badge' => 'info'],
            self::ACCEPTED_CER_BY_ADMINLATAS => ['label' => 'Menunggu Instruktur Sertifikasi', 'badge' => 'warning'],
            self::ACCEPTED_CER_BY_INSCER => ['label' => 'Menunggu KABID LATTAS', 'badge' => 'secondary'],
            self::ACCEPTED_CER_BY_KABIDLATAS => ['label' => 'Menunggu Persetujuan KADIS', 'badge' => 'primary'],
            self::APPROVED_CER => ['label' => 'Disetujui / Selesai', 'badge' => 'success'],
            self::REJECTED_CER => ['label' => 'Ditolak', 'badge' => 'danger'],
            default => ['label' => 'Draft', 'badge' => 'secondary'],
        };
    }

    public static function disputeStatusLabel(int $status): array
    {
        return match ($status) {
            self::DISPUTE_SEND_BY_USER => ['label' => 'Masuk (Menunggu Admin PSP)', 'badge' => 'info'],
            self::DISPUTE_ACCEPTED_ADMIN_PSP => ['label' => 'Diteruskan ke KABID PSP/HI', 'badge' => 'primary'],
            self::DISPUTE_ACCEPTED_KABID => ['label' => 'Ditangani Mediator', 'badge' => 'warning'],
            self::DISPUTE_CLEARED_MEDIATOR => ['label' => 'Diselesaikan Mediator (Menunggu KABID)', 'badge' => 'info'],
            self::DISPUTE_FINISHED_KABID => ['label' => 'Selesai / Ditutup', 'badge' => 'success'],
            self::DISPUTE_UNSOLVED => ['label' => 'Tidak Selesai / Bipartit Lanjutan', 'badge' => 'danger'],
            default => ['label' => 'Diproses', 'badge' => 'secondary'],
        };
    }
}
