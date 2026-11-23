<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAndMenuSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id_role' => 1, 'role' => 'Super Administrator'],
            ['id_role' => 2, 'role' => 'Admin Reg'],
            ['id_role' => 3, 'role' => 'Admin Penta'],
            ['id_role' => 4, 'role' => 'Admin Lattas'],
            ['id_role' => 5, 'role' => 'Admin Hub Industrial'],
            ['id_role' => 6, 'role' => 'Admin PSP'],
            ['id_role' => 7, 'role' => 'KADIS'],
            ['id_role' => 8, 'role' => 'Pengantar Kerja'],
            ['id_role' => 9, 'role' => 'Instruktur Pelatihan'],
            ['id_role' => 10, 'role' => 'Instruktur Produktivitas'],
            ['id_role' => 11, 'role' => 'Instruktur Sertifikasi'],
            ['id_role' => 12, 'role' => 'Mediator'],
            ['id_role' => 13, 'role' => 'Perusahaan'],
            ['id_role' => 14, 'role' => 'Angkatan Kerja'],
            ['id_role' => 15, 'role' => 'Lembaga Pelatihan Kerja'],
            ['id_role' => 16, 'role' => 'KABID PENTA'],
            ['id_role' => 17, 'role' => 'KABID LATTAS'],
            ['id_role' => 18, 'role' => 'KABID PSP'],
            ['id_role' => 19, 'role' => 'KABID HI'],
            ['id_role' => 20, 'role' => 'Sekretaris'],
            ['id_role' => 21, 'role' => 'Admin Sekretariat'],
            ['id_role' => 22, 'role' => 'Viewer'],
            ['id_role' => 23, 'role' => 'BPJS KETENAGAKERJAAN'],
            ['id_role' => 24, 'role' => 'BPJS KESEHATAN'],
        ];
        DB::table('user_role')->insert($roles);

        $menus = [
            ['id' => 1, 'menu' => 'Administrator', 'position' => 1],
            ['id' => 2, 'menu' => 'User', 'position' => 7],
            ['id' => 3, 'menu' => 'Settings', 'position' => 8],
            ['id' => 4, 'menu' => 'Data', 'position' => 3],
            ['id' => 5, 'menu' => 'Registrasi', 'position' => 6],
            ['id' => 6, 'menu' => 'Pengajuan', 'position' => 5],
            ['id' => 7, 'menu' => 'Akun', 'position' => 4],
            ['id' => 8, 'menu' => 'Management', 'position' => 2],
            ['id' => 9, 'menu' => 'Penanganan', 'position' => 9],
        ];
        DB::table('user_menu')->insert($menus);

        $subMenus = [
            ['id' => 1, 'menu_id' => 1, 'title' => 'Dashboard', 'url' => 'adm/administrator', 'icon' => 'fas fa-fw fa-tachometer-alt', 'is_active' => 1],
            ['id' => 2, 'menu_id' => 2, 'title' => 'Profil', 'url' => 'adm/user', 'icon' => 'fas fa-fw fa-user', 'is_active' => 1],
            ['id' => 3, 'menu_id' => 2, 'title' => 'Edit Profil', 'url' => 'adm/user/edit', 'icon' => 'fas fa-fw fa-user-edit', 'is_active' => 1],
            ['id' => 4, 'menu_id' => 3, 'title' => 'Navbar', 'url' => 'adm/settings', 'icon' => 'fa fa-bars', 'is_active' => 1],
            ['id' => 5, 'menu_id' => 3, 'title' => 'Nav Item', 'url' => 'adm/settings/submenu', 'icon' => 'fas fa-fw fa-folder-open', 'is_active' => 1],
            ['id' => 6, 'menu_id' => 1, 'title' => 'Role', 'url' => 'adm/administrator/role', 'icon' => 'fas fa-fw fa-user-tie', 'is_active' => 1],
            ['id' => 7, 'menu_id' => 2, 'title' => 'Ubah Password', 'url' => 'adm/user/changepassword', 'icon' => 'fas fa-fw fa-key', 'is_active' => 1],
            ['id' => 8, 'menu_id' => 4, 'title' => 'Bidang Pekerjaan', 'url' => 'adm/data/job_field', 'icon' => 'fa fa-briefcase', 'is_active' => 1],
            ['id' => 9, 'menu_id' => 4, 'title' => 'Sub Bidang Pekerjaan', 'url' => 'adm/data/subjob_field', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 10, 'menu_id' => 4, 'title' => 'Tingkat Pendidikan', 'url' => 'adm/data/education_level', 'icon' => 'fa fa-graduation-cap', 'is_active' => 1],
            ['id' => 11, 'menu_id' => 4, 'title' => 'Keahlian', 'url' => 'adm/data/skill', 'icon' => 'fa fa-certificate', 'is_active' => 1],
            ['id' => 12, 'menu_id' => 4, 'title' => 'Sekolah', 'url' => 'adm/data/school', 'icon' => 'fa fa-book', 'is_active' => 1],
            ['id' => 13, 'menu_id' => 4, 'title' => 'Universitas', 'url' => 'adm/data/university', 'icon' => 'fa fa-university', 'is_active' => 1],
            ['id' => 14, 'menu_id' => 5, 'title' => 'Angkatan Kerja', 'url' => 'adm/registrasi', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 15, 'menu_id' => 5, 'title' => 'LPK', 'url' => 'adm/registrasi/lpk', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 16, 'menu_id' => 5, 'title' => 'Perusahaan', 'url' => 'adm/registrasi/perusahaan', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 17, 'menu_id' => 4, 'title' => 'Kategori Perusahaan', 'url' => 'adm/data/category_company', 'icon' => 'fa fa-industry', 'is_active' => 1],
            ['id' => 18, 'menu_id' => 4, 'title' => 'Jenis Badan Usaha', 'url' => 'adm/data/badan_usaha', 'icon' => 'fa fa-building', 'is_active' => 1],
            ['id' => 19, 'menu_id' => 7, 'title' => 'Akun Pengguna', 'url' => 'adm/akun/user_account', 'icon' => 'fas fa-fw fa-folder-open', 'is_active' => 1],
            ['id' => 20, 'menu_id' => 4, 'title' => 'Potensial Sektor', 'url' => 'adm/data/sector_potential', 'icon' => 'fas fa-fw fa-folder-open', 'is_active' => 1],
            ['id' => 21, 'menu_id' => 4, 'title' => 'Kejuruan LPK', 'url' => 'adm/data/vocational', 'icon' => 'fa fa-search-plus', 'is_active' => 1],
            ['id' => 22, 'menu_id' => 4, 'title' => 'Jenis Disabilitas', 'url' => 'adm/data/disability', 'icon' => 'fa fa-users', 'is_active' => 1],
            ['id' => 23, 'menu_id' => 8, 'title' => 'Lowongan Kerja', 'url' => 'adm/management/job_vacancy', 'icon' => 'fa fa-briefcase', 'is_active' => 1],
            ['id' => 24, 'menu_id' => 8, 'title' => 'Pemagangan', 'url' => 'adm/management/internship', 'icon' => 'fa fa-id-card', 'is_active' => 1],
            ['id' => 25, 'menu_id' => 8, 'title' => 'Pelatihan', 'url' => 'adm/management/training', 'icon' => 'fa fa-star', 'is_active' => 1],
            ['id' => 26, 'menu_id' => 8, 'title' => 'Akun Pengguna', 'url' => 'adm/management/account', 'icon' => 'fa fa-user-circle', 'is_active' => 1],
            ['id' => 27, 'menu_id' => 8, 'title' => 'Registrasi', 'url' => 'adm/management/register', 'icon' => 'fa fa-registered', 'is_active' => 1],
            ['id' => 28, 'menu_id' => 4, 'title' => 'Akses Notifikasi', 'url' => 'adm/data/notification', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 29, 'menu_id' => 8, 'title' => 'Sertifikasi', 'url' => 'adm/management/certification', 'icon' => 'fa fa-certificate', 'is_active' => 1],
            ['id' => 30, 'menu_id' => 8, 'title' => 'AK-1', 'url' => 'adm/management/ak_1', 'icon' => 'fa fa-address-card', 'is_active' => 1],
            ['id' => 31, 'menu_id' => 8, 'title' => 'FAQ', 'url' => 'adm/management/faq', 'icon' => 'fa fa-question', 'is_active' => 1],
            ['id' => 32, 'menu_id' => 8, 'title' => 'Perselisihan', 'url' => 'adm/management/dispute', 'icon' => 'fas fa-tasks', 'is_active' => 1],
            ['id' => 33, 'menu_id' => 4, 'title' => 'Kategori Perselisihan', 'url' => 'adm/data/category_dispute', 'icon' => 'fas fa-list', 'is_active' => 1],
            ['id' => 34, 'menu_id' => 4, 'title' => 'Jurusan', 'url' => 'adm/data/major', 'icon' => 'fas fa-book-open', 'is_active' => 1],
            ['id' => 35, 'menu_id' => 8, 'title' => 'Pelayanan HI', 'url' => 'adm/management/pelayanan', 'icon' => 'fas fa-home', 'is_active' => 1],
            ['id' => 36, 'menu_id' => 4, 'title' => 'Jabatan', 'url' => 'adm/data/jabatan', 'icon' => 'fa fa-address-card', 'is_active' => 1],
            ['id' => 37, 'menu_id' => 8, 'title' => 'Laporan LPK', 'url' => 'adm/management/report/lpk', 'icon' => 'fa fa-print', 'is_active' => 1],
            ['id' => 38, 'menu_id' => 8, 'title' => 'Survey Kepuasan', 'url' => 'adm/management/survey', 'icon' => 'fa fa-address-card', 'is_active' => 1],
            ['id' => 39, 'menu_id' => 8, 'title' => 'Penempatan Pencaker', 'url' => 'adm/management/placement', 'icon' => 'fa fa-book', 'is_active' => 1],
            ['id' => 40, 'menu_id' => 4, 'title' => 'Status Modal Perusahaan', 'url' => 'adm/data/status_modal', 'icon' => 'fas fa-coins', 'is_active' => 1],
        ];
        DB::table('user_sub_menu')->insert($subMenus);

        $accessPairs = [
            [1, 1], [1, 2], [1, 3], [1, 4], [1, 5], [1, 6], [1, 7], [1, 8], [1, 9],
            [2, 2], [2, 4], [2, 8],
            [3, 2], [3, 4], [3, 8],
            [4, 2], [4, 4], [4, 8],
            [5, 2], [5, 8],
            [6, 2], [6, 8],
            [7, 1], [7, 2], [7, 4], [7, 8], [7, 9],
            [8, 2], [8, 4], [8, 8],
            [9, 2], [9, 4], [9, 8],
            [10, 2], [10, 4], [10, 8],
            [11, 2], [11, 3], [11, 8],
            [12, 2], [12, 4], [12, 8],
            [16, 1], [16, 2], [16, 4], [16, 8],
            [17, 1], [17, 2], [17, 4], [17, 8],
            [18, 1], [18, 2], [18, 4], [18, 8],
            [19, 1], [19, 2], [19, 4], [19, 8],
            [20, 1], [20, 2], [20, 4], [20, 8],
            [21, 1], [21, 2], [21, 4], [21, 8],
            [22, 1], [22, 2], [22, 4], [22, 5], [22, 7], [22, 8],
            [23, 2], [23, 8],
            [24, 2], [24, 8],
        ];

        $rows = array_map(fn ($p) => ['role_id' => $p[0], 'menu_id' => $p[1]], $accessPairs);
        DB::table('user_access_menu')->insert($rows);

        $subtypes = [
            [4, 1], [4, 2], [5, 1], [5, 7], [5, 20], [5, 21],
            [6, 1], [6, 3], [6, 7], [6, 16], [6, 20], [6, 21],
            [7, 1], [7, 17], [8, 1], [8, 7], [8, 10], [8, 20], [8, 21],
            [10, 1], [10, 7], [10, 17], [10, 20], [10, 21],
            [11, 1], [11, 17], [12, 1], [12, 7], [12, 9], [12, 20], [12, 21],
            [14, 1], [14, 4], [14, 7], [14, 9], [14, 10], [14, 17], [14, 20], [14, 21],
            [15, 1], [15, 3], [15, 8], [15, 16],
            [18, 1], [18, 4], [19, 1], [19, 11], [20, 1], [20, 17], [21, 1], [21, 7],
            [24, 3], [24, 8], [25, 8], [26, 14], [27, 14],
            [28, 1], [28, 3], [28, 8], [29, 1], [29, 10], [29, 17], [30, 1], [30, 9], [30, 17],
            [31, 1], [31, 6], [31, 19], [32, 1], [32, 18], [32, 19], [33, 1], [33, 12], [33, 19],
            [36, 1], [36, 18], [36, 19],
        ];
        DB::table('subtypelist_notification')->insert(
            array_map(fn ($s) => ['id_subtype' => $s[0], 'role_id' => $s[1], 'deleted_subtype' => '0'], $subtypes)
        );
    }
}
