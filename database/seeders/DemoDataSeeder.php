<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Staff & Admin Users + 1 Jobseeker Demo Account
        $users = [
            ['id' => 1, 'first_name' => 'Super', 'last_name' => 'Admin', 'email' => 'admin@siduta.test', 'role_id' => 1, 'reg_status' => 3],
            ['id' => 2, 'first_name' => 'Admin', 'last_name' => 'Penta', 'email' => 'penta@siduta.test', 'role_id' => 3, 'reg_status' => 3],
            ['id' => 3, 'first_name' => 'Pengantar', 'last_name' => 'Kerja', 'email' => 'pengantarkerja@siduta.test', 'role_id' => 8, 'reg_status' => 3],
            ['id' => 4, 'first_name' => 'Kabid', 'last_name' => 'Penta', 'email' => 'kabidpenta@siduta.test', 'role_id' => 16, 'reg_status' => 3],
            ['id' => 5, 'first_name' => 'Admin', 'last_name' => 'Lattas', 'email' => 'lattas@siduta.test', 'role_id' => 4, 'reg_status' => 3],
            ['id' => 6, 'first_name' => 'Instruktur', 'last_name' => 'Pelatihan', 'email' => 'instruktur.pelatihan@siduta.test', 'role_id' => 9, 'reg_status' => 3],
            ['id' => 7, 'first_name' => 'Instruktur', 'last_name' => 'Produktivitas', 'email' => 'instruktur.prod@siduta.test', 'role_id' => 10, 'reg_status' => 3],
            ['id' => 8, 'first_name' => 'Instruktur', 'last_name' => 'Sertifikasi', 'email' => 'instruktur.sert@siduta.test', 'role_id' => 11, 'reg_status' => 3],
            ['id' => 9, 'first_name' => 'Kabid', 'last_name' => 'Lattas', 'email' => 'kabidlattas@siduta.test', 'role_id' => 17, 'reg_status' => 3],
            ['id' => 10, 'first_name' => 'Admin', 'last_name' => 'PSP', 'email' => 'psp@siduta.test', 'role_id' => 6, 'reg_status' => 3],
            ['id' => 11, 'first_name' => 'Kabid', 'last_name' => 'HI & PSP', 'email' => 'kabidhi@siduta.test', 'role_id' => 19, 'reg_status' => 3],
            ['id' => 12, 'first_name' => 'Mediator', 'last_name' => 'Disnaker', 'email' => 'mediator@siduta.test', 'role_id' => 12, 'reg_status' => 3],
            ['id' => 13, 'first_name' => 'Kepala', 'last_name' => 'Dinas', 'email' => 'kadis@siduta.test', 'role_id' => 7, 'reg_status' => 3],
            ['id' => 14, 'first_name' => 'Petugas', 'last_name' => 'BPJS TK', 'email' => 'bpjstk@siduta.test', 'role_id' => 23, 'reg_status' => 3],
            ['id' => 15, 'first_name' => 'Petugas', 'last_name' => 'BPJS Kesehatan', 'email' => 'bpjsks@siduta.test', 'role_id' => 24, 'reg_status' => 3],
            [
                'id' => 16,
                'first_name' => 'Budi',
                'last_name' => 'Santoso',
                'email' => 'pencaker@siduta.test',
                'role_id' => 14,
                'reg_status' => 3,
                'gender' => 'laki-laki',
                'dob' => '1998-05-14',
                'no_handphone' => '081234567890',
                'address' => 'Jl. Jamin Ginting No. 45, Medan Baru',
                'place_birth' => 'Medan',
                'religion' => 'Islam',
                'status' => 'Belum Kawin',
                'district' => 'Medan Baru',
                'job_field' => 21,
                'sub_job_field' => 6,
                'education_level' => 6,
                'educational_institutions' => 1,
                'major' => 'Teknik Informatika',
                'start_period' => '2016-09-01',
                'end_period' => '2020',
                'ipk' => 3.65,
                'nik' => '1271011405980001',
            ],
        ];

        foreach ($users as $u) {
            DB::table('user')->insert(array_merge([
                'image' => 'default.jpg',
                'password' => $password,
                'is_active' => 1,
                'date_create' => time(),
                'deleted_user' => '0',
            ], $u));
        }

        DB::table('user_listskill')->insert([
            ['user_id' => 16, 'skill_id' => 1],
            ['user_id' => 16, 'skill_id' => 2],
            ['user_id' => 16, 'skill_id' => 7],
        ]);

        DB::table('user_experience')->insert([
            ['user_id' => 16, 'position' => 'Junior Web Developer', 'company' => 'CV Digital Medan', 'time' => '2021 - 2024', 'description' => 'Mengembangkan aplikasi layanan publik berbasis web.'],
        ]);

        DB::table('user_language')->insert([
            ['id_user' => 16, 'language' => 'Bahasa Indonesia', 'deleted' => 0],
            ['id_user' => 16, 'language' => 'Bahasa Inggris', 'deleted' => 0],
        ]);

        // 2. Demo Companies
        DB::table('company')->insert([
            [
                'id_company' => 1,
                'name_company' => 'Medan Teknologi Nusantara',
                'address_company' => 'Jl. Sudirman No. 88, Kota Medan',
                'email_company' => 'perusahaan@siduta.test',
                'password_company' => $password,
                'logo_company' => 'default.png',
                'category_company' => 4,
                'badanusaha_company' => 1,
                'hp_company' => '061-4551234',
                'pj_company' => 'Andi Wijaya',
                'npwp_company' => '01.234.567.8-121.000',
                'nib_company' => '9120102938475',
                'legal_status' => '1',
                'cp_penanggungjawab' => '08116000111',
                'is_activecompany' => 1,
                'status_regcompany' => 1,
                'deleted_company' => '0',
                'name_direktur' => 'Hendra Gunawan',
                'jabatan_pj' => 'HR Manager',
            ],
            [
                'id_company' => 2,
                'name_company' => 'Agro Sumatera Sejahtera',
                'address_company' => 'Jl. Gatot Subroto Km 5, Kota Medan',
                'email_company' => 'agro@siduta.test',
                'password_company' => $password,
                'logo_company' => 'default.png',
                'category_company' => 7,
                'badanusaha_company' => 1,
                'hp_company' => '061-8449900',
                'pj_company' => 'Rina Nasution',
                'npwp_company' => '02.334.567.8-122.000',
                'nib_company' => '8120102938499',
                'legal_status' => '0',
                'cp_penanggungjawab' => '08126000222',
                'is_activecompany' => 1,
                'status_regcompany' => 1,
                'deleted_company' => '0',
                'name_direktur' => 'Surya Pratama',
                'jabatan_pj' => 'Direktur Operasional',
            ],
        ]);

        // 3. Demo LPK
        DB::table('lpk')->insert([
            [
                'id_lpk' => 1,
                'name_lpk' => 'LPK Cerdas Karya Medan',
                'name_leader' => 'Drs. Ahmad Lubis',
                'email_lpk' => 'lpk@siduta.test',
                'role_id' => 15,
                'password_lpk' => $password,
                'address_lpk' => 'Jl. Iskandar Muda No. 120, Kota Medan',
                'no_telp' => '061-4527788',
                'nohp_pimpinan' => '081370008899',
                'year_lpk' => '2018-05-01',
                'no_vin' => 'VIN-1271-001',
                'daya_tampung_lpk' => 120,
                'legal_status' => 3,
                'potential_sector_id' => 8,
                'exellent_vocational_id' => 6,
                'logo_lpk' => 'default.png',
                'is_activelpk' => 1,
                'deleted_lpk' => '0',
                'no_izin_lpk' => '563/102/DISNAKER/2021',
                'no_akreditasi_lpk' => 'AKR-LA-LPK-2023-09',
                'count_staff' => 15,
                'namapj_lpk' => 'Siti Aminah',
                'nopj_lpk' => '081370001122',
                'jabatanpj_lpk' => 'Kepala Program',
            ],
        ]);
        DB::table('lpk_listvocational')->insert([
            ['lpk_id' => 1, 'vocational_id' => 6],
            ['lpk_id' => 1, 'vocational_id' => 31],
        ]);

        // 4. AK-1 Sample (Approved for pencaker@siduta.test so apply & print QR works out of the box)
        DB::table('ak1')->insert([
            ['id_ak1' => 1, 'user_id' => 16, 'process_status' => 3, 'approved_by' => 3, 'updated_at' => now(), 'deleted_ak1' => 0],
        ]);
        DB::table('user_desired_job')->insert([
            ['id_user' => 16, 'id_ak1' => 1, 'position' => 'Fullstack Web Developer', 'sallary' => '6500000', 'placement' => 'Dalam Kota', 'location' => '1', 'deleted' => 0, 'nation' => 'Indonesia'],
        ]);

        // 5. Job Vacancies (Published & Pending)
        DB::table('job_vacancy')->insert([
            [
                'id_jobvacancy' => 1,
                'title_jobvacancy' => 'Fullstack Web Developer (Laravel)',
                'experience_vacancy' => 1,
                'salary_start' => '5500000',
                'salary_end' => '8500000',
                'desc_vacancy' => '<p>Membangun dan memelihara sistem informasi layanan publik serta aplikasi internal perusahaan menggunakan Laravel 13 dan MySQL.</p><ul><li>Menguasai PHP 8.3+, Laravel, dan REST API</li><li>Terbiasa dengan Git dan keamanan web</li></ul>',
                'jobfield_vacancy' => 21,
                'subjobfield_vacancy' => 6,
                'type_vacancy' => 1,
                'city_vacancy' => 1,
                'duration_vacancy' => 12,
                'deadline_vacancy' => now()->addDays(45)->toDateString(),
                'disability_status' => 1,
                'publish_status' => 1,
                'process_status' => 3,
                'company_id' => 1,
                'pk_id' => 3,
                'deleted_vacancy' => '0',
                'publish_date' => now(),
                'education_level' => 6,
            ],
            [
                'id_jobvacancy' => 2,
                'title_jobvacancy' => 'Staf Administrasi & Keuangan',
                'experience_vacancy' => 1,
                'salary_start' => '4000000',
                'salary_end' => '5500000',
                'desc_vacancy' => '<p>Mengelola administrasi perkantoran, pembukuan keuangan harian, dan pelaporan pajak perusahaan di Medan.</p>',
                'jobfield_vacancy' => 3,
                'subjobfield_vacancy' => 1,
                'type_vacancy' => 1,
                'city_vacancy' => 1,
                'duration_vacancy' => 12,
                'deadline_vacancy' => now()->addDays(30)->toDateString(),
                'disability_status' => 0,
                'publish_status' => 1,
                'process_status' => 3,
                'company_id' => 1,
                'pk_id' => 3,
                'deleted_vacancy' => '0',
                'publish_date' => now(),
                'education_level' => 5,
            ],
            [
                'id_jobvacancy' => 3,
                'title_jobvacancy' => 'Supervisor Operasional Lapangan',
                'experience_vacancy' => 2,
                'salary_start' => '5000000',
                'salary_end' => '7000000',
                'desc_vacancy' => '<p>Menunggu verifikasi Pengantar Kerja Disnaker Kota Medan.</p>',
                'jobfield_vacancy' => 28,
                'subjobfield_vacancy' => 9,
                'type_vacancy' => 1,
                'city_vacancy' => 1,
                'duration_vacancy' => 12,
                'deadline_vacancy' => now()->addDays(30)->toDateString(),
                'disability_status' => 0,
                'publish_status' => 0,
                'process_status' => 1,
                'company_id' => 1,
                'pk_id' => null,
                'deleted_vacancy' => '0',
                'publish_date' => null,
                'education_level' => 6,
            ],
        ]);
        DB::table('jv_listskill')->insert([
            ['jv_id' => 1, 'skill_id' => 2],
            ['jv_id' => 1, 'skill_id' => 7],
            ['jv_id' => 2, 'skill_id' => 1],
            ['jv_id' => 2, 'skill_id' => 3],
        ]);
        DB::table('job_listdisability')->insert([
            ['job_vacancy_id' => 1, 'disability_id' => 4],
        ]);

        // 6. Internships & Trainings
        DB::table('internship')->insert([
            [
                'id_intern' => 1,
                'title_intern' => 'Magang UI/UX & Frontend Developer',
                'experience_intern' => 0,
                'salary_start' => '1500000',
                'salary_end' => '2500000',
                'desc_intern' => '<p>Program pemagangan selama 3 bulan untuk lulusan baru atau mahasiswa tingkat akhir di Kota Medan.</p>',
                'jobfield_intern' => '21',
                'subjobfield_intern' => 11,
                'city_intern' => 1,
                'duration_intern' => 3,
                'deadline_intern' => now()->addDays(30)->toDateString(),
                'publish_status' => 1,
                'process_status' => 3,
                'company_id' => 1,
                'ip_id' => 7,
                'deleted_intern' => '0',
                'length_intern' => 3,
                'min_edu_level' => 4,
            ],
        ]);
        DB::table('in_listskill')->insert([['in_id' => 1, 'skill_id' => 5]]);

        DB::table('training')->insert([
            [
                'id_training' => 1,
                'title_training' => 'Pelatihan Kompetensi Web Development & Digital Marketing',
                'desc_training' => '<p>Pelatihan berbasis kompetensi SKKNI untuk pencari kerja Kota Medan dengan sertifikat resmi Disnaker & LPK.</p>',
                'city_training' => 1,
                'price_training' => '0',
                'method_training' => 1,
                'gender_training' => 0,
                'minage_training' => '18',
                'maxage_training' => '35',
                'duration_training' => 30,
                'deadline_training' => now()->addDays(25)->toDateString(),
                'date_training' => now()->addDays(30)->toDateString(),
                'place_training' => 'LPK Cerdas Karya Medan',
                'duration_study' => 120,
                'disability_status' => 1,
                'certificate_status' => 1,
                'publish_status' => 1,
                'process_status' => 3,
                'lpk_id' => 1,
                'ipo_id' => 6,
                'deleted_training' => '0',
                'tujuan_tr' => 'Meningkatkan daya saing angkatan kerja di bidang digital.',
            ],
        ]);

        // 7. Certification Sample
        DB::table('certification')->insert([
            [
                'id_certification' => 1,
                'lpk_id' => 1,
                'name_certification' => 'Sertifikasi Kompetensi Junior Web Programmer',
                'totalh_certification' => 80,
                'vocational_id' => 6,
                'totaluser_certification' => 1,
                'date_certification' => now()->subDays(5)->toDateString(),
                'loc_certification' => 'Aula LPK Cerdas Karya Medan',
                'process_status' => 5,
                'updated_at' => now(),
                'deleted_certification' => 0,
            ],
        ]);
        DB::table('list_certification')->insert([
            [
                'id_lc' => 1,
                'certification_id' => 1,
                'user_id' => 16,
                'certification_code' => 'SIDUTA-CERT-2026-0001',
                'deleted_lc' => 0,
            ],
        ]);

        // 8. Dispute & FAQ Sample
        DB::table('dispute')->insert([
            [
                'id' => 1,
                'title' => 'Perselisihan Hak dan Kewajiban',
                'description' => 'Keterlambatan pembayaran upah lembur selama 2 bulan.',
                'status' => 2,
                'mediator' => 12,
                'deleted' => 0,
                'user_created' => 16,
                'nama' => 'Budi Santoso',
                'nik' => '1271011405980001',
                'email' => 'pencaker@siduta.test',
                'hp' => '081234567890',
                'alamat' => 'Jl. Jamin Ginting No. 45, Medan',
                'company' => 'PT Contoh Sejahtera',
                'address_company' => 'Jl. Sisingamangaraja Medan',
                'updated_at' => now(),
            ],
        ]);
        DB::table('dispute_log')->insert([
            ['id_dispute' => 1, 'action' => 'Laporan pengaduan dikirim oleh pelapor.'],
            ['id_dispute' => 1, 'action' => 'Diverifikasi Admin PSP dan diteruskan ke KABID HI.'],
            ['id_dispute' => 1, 'action' => 'Mediator Disnaker ditugaskan untuk mediasi tripartit.'],
        ]);

        DB::table('faq')->insert([
            ['question' => 'Bagaimana cara membuat Kartu Kuning (AK-1) secara online di SIDUTA?', 'answer' => 'Daftar dan lengkapi seluruh profil Pencari Kerja, lalu masuk ke menu Pengajuan AK-1 di Dashboard Anda. Setelah diverifikasi Admin Penta dan disetujui Pengantar Kerja, kartu AK-1 dengan QR Code dapat langsung dicetak.', 'id_category_faq' => 1, 'category_user' => 0, 'is_published' => 1, 'deleted' => 0],
            ['question' => 'Apakah pembuatan AK-1 dan pendaftaran lowongan dikenakan biaya?', 'answer' => 'Tidak. Seluruh layanan Dinas Ketenagakerjaan Kota Medan melalui SIDUTA 100% gratis tanpa pungutan biaya.', 'id_category_faq' => 1, 'category_user' => 0, 'is_published' => 1, 'deleted' => 0],
            ['question' => 'Bagaimana perusahaan mengajukan pengesahan Peraturan Perusahaan (PP) atau PKWT?', 'answer' => 'Login ke Portal Perusahaan, pilih menu Pelayanan Hubungan Industrial (PP/PKWT/PKB), lengkapi data NPP, NIB, kode badan usaha, serta unggah dokumen persyaratan.', 'id_category_faq' => 11, 'category_user' => 2, 'is_published' => 1, 'deleted' => 0],
            ['question' => 'Bagaimana LPK melaporkan kegiatan semesteran?', 'answer' => 'Login ke Portal LPK dan buka menu Laporan Semester untuk mengisi jumlah karyawan, kegiatan pelatihan P2/P3/TUK, kemitraan, dan kendala.', 'id_category_faq' => 4, 'category_user' => 1, 'is_published' => 1, 'deleted' => 0],
        ]);

        // 9. Industrial Relations & Placement Sample
        DB::table('karyawan')->insert([
            ['company_id' => 1, 'identity' => '1271020101950002', 'nama' => 'Sari Dewi', 'sex' => 2, 'tgl_lahir' => '1995-01-01', 'tmpt_lahir' => 'Medan', 'jabatan' => 'HR & GA Officer', 'education' => 6, 'salary' => 5500000, 'is_bpjs_tk' => 1, 'is_bpjs_kesehatan' => 1, 'is_active' => 1],
        ]);
        DB::table('wlkp')->insert([
            ['company_id' => 1, 'no_wlkp' => 'WLKP-MDN-2026-001', 'tahun_wlkp' => '2026', 'file_lampiran' => '', 'created_by' => 1],
        ]);
        DB::table('serikat')->insert([
            ['nama_serikat' => 'SP Teknologi Nusantara Medan', 'company_id' => 1, 'no_serikat_reg' => 'REG-SP-2026-01', 'address_serikat' => 'Jl. Sudirman No. 88 Medan', 'jumlah_anggota' => 25],
        ]);
        DB::table('permohonan_pp')->insert([
            ['company_id' => 1, 'npp' => 'NPP-1271001', 'kode_badan_usaha' => 'BU-1271001', 'nib' => '9120102938475', 'status_modal_company' => 2, 'bidang_usaha' => 'Teknologi Informasi', 'tgl_surat_izin' => '2024-01-15', 'upah_min' => 3800000, 'upah_max' => 12000000, 'has_sp_sb' => 1, 'process_status' => 0, 'created_by' => 1, 'updated_by' => 1],
        ]);
        DB::table('report_tkdn')->insert([
            ['nama' => 'Budi Santoso', 'nik' => '1271011405980001', 'jenis_kelamin' => 'Laki-laki', 'last_education' => 'S1', 'jurusan' => 'Teknik Informatika', 'no_telp' => '081234567890', 'jabatan' => 'Web Developer', 'company_name' => 'PT. Medan Teknologi Nusantara', 'company_address' => 'Jl. Sudirman No. 88 Medan', 'is_processed' => 1, 'company_id' => 1, 'user_id' => 16, 'id_jobvacancy' => 1, 'year' => '2026'],
        ]);
        DB::table('tka')->insert([
            ['name_cpmi' => 'Rizky Pratama', 'nik' => '1271030508990003', 'jenis_kelamin' => 'Laki-laki', 'last_education' => 'SMK', 'jabatan' => 'Welder SMAW', 'ttl' => 'Medan, 05-08-1999', 'address' => 'Medan Marelan', 'status' => 'Berangkat', 'company' => 'PT Penempatan Migran Nusantara', 'country_of_destination' => 'Jepang', 'destination' => 'Osaka', 'no_telp' => '081399887766', 'year' => '2026'],
        ]);

        // 10. LPK Semester Report Sample
        DB::table('jumlahkaryawan_lpk')->insert([
            ['lpk_id' => 1, 'tpt_lk' => 4, 'tpt_p' => 3, 'it_lk' => 5, 'it_p' => 3, 'sms' => 1, 'yr1' => 2026, 'yr2' => 2026, 'is_deleted' => 0, 'is_locked' => 0],
        ]);
    }
}
