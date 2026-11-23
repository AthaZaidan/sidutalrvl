<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['id_prov' => 2, 'prov_name' => 'Sumatera Utara', 'locationid' => 2, 'status' => 1],
            ['id_prov' => 11, 'prov_name' => 'DKI Jakarta', 'locationid' => 11, 'status' => 1],
            ['id_prov' => 12, 'prov_name' => 'Jawa Barat', 'locationid' => 12, 'status' => 1],
        ]);

        DB::table('cities')->insert([
            ['id_city' => 1, 'city_name' => 'Kota Medan', 'prov_id' => 2],
            ['id_city' => 2, 'city_name' => 'Kota Binjai', 'prov_id' => 2],
            ['id_city' => 3, 'city_name' => 'Kabupaten Deli Serdang', 'prov_id' => 2],
            ['id_city' => 4, 'city_name' => 'Kota Tebing Tinggi', 'prov_id' => 2],
            ['id_city' => 5, 'city_name' => 'Kota Pematangsiantar', 'prov_id' => 2],
            ['id_city' => 6, 'city_name' => 'Jakarta Pusat', 'prov_id' => 11],
            ['id_city' => 7, 'city_name' => 'Kota Bandung', 'prov_id' => 12],
        ]);

        DB::table('countries')->insert([
            ['id' => 1, 'name' => 'Indonesia', 'continent' => 'Asia', 'phone' => 62],
            ['id' => 2, 'name' => 'Malaysia', 'continent' => 'Asia', 'phone' => 60],
            ['id' => 3, 'name' => 'Singapura', 'continent' => 'Asia', 'phone' => 65],
            ['id' => 4, 'name' => 'Jepang', 'continent' => 'Asia', 'phone' => 81],
            ['id' => 5, 'name' => 'Korea Selatan', 'continent' => 'Asia', 'phone' => 82],
        ]);

        DB::table('badan_usaha')->insert([
            ['id_badanusaha' => 1, 'name_badanusaha' => 'PT.', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 2, 'name_badanusaha' => 'CV.', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 3, 'name_badanusaha' => 'UD.', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 4, 'name_badanusaha' => 'Yayasan', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 5, 'name_badanusaha' => 'Koperasi', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 6, 'name_badanusaha' => 'PP.', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 7, 'name_badanusaha' => 'Kementerian', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 8, 'name_badanusaha' => 'BUMN', 'deleted_badanusaha' => '0'],
            ['id_badanusaha' => 9, 'name_badanusaha' => 'BUMD', 'deleted_badanusaha' => '0'],
        ]);

        DB::table('category')->insert([
            ['id_category' => 1, 'name_category' => 'Perusahaan Ekstraktif', 'deleted_category' => '0'],
            ['id_category' => 2, 'name_category' => 'Perusahaan Industri atau Manufaktur', 'deleted_category' => '0'],
            ['id_category' => 4, 'name_category' => 'Perusahaan Jasa', 'deleted_category' => '0'],
            ['id_category' => 5, 'name_category' => 'Perusahaan Dagang', 'deleted_category' => '0'],
            ['id_category' => 6, 'name_category' => 'Perusahaan Lainnya', 'deleted_category' => '0'],
            ['id_category' => 7, 'name_category' => 'Perusahaan Perkebunan', 'deleted_category' => '0'],
            ['id_category' => 8, 'name_category' => 'Pariwisata', 'deleted_category' => '0'],
            ['id_category' => 9, 'name_category' => 'Kesehatan', 'deleted_category' => '0'],
            ['id_category' => 11, 'name_category' => 'Retail', 'deleted_category' => '0'],
            ['id_category' => 13, 'name_category' => 'Perbankan & Finance', 'deleted_category' => '0'],
        ]);

        DB::table('company_status_modal')->insert([
            ['id' => 1, 'name' => 'PMDN', 'is_deleted' => 0],
            ['id' => 2, 'name' => 'Swasta Nasional', 'is_deleted' => 0],
            ['id' => 3, 'name' => 'PMA', 'is_deleted' => 0],
            ['id' => 4, 'name' => 'Joint Venture', 'is_deleted' => 0],
        ]);

        DB::table('disability')->insert([
            ['id_disability' => 1, 'name_disability' => 'Tuna Netra (Buta)', 'deleted_disability' => '0'],
            ['id_disability' => 2, 'name_disability' => 'Tuna Rungu (Tuli)', 'deleted_disability' => '0'],
            ['id_disability' => 3, 'name_disability' => 'Tuna Wicara (Bisu)', 'deleted_disability' => '0'],
            ['id_disability' => 4, 'name_disability' => 'Tuna Daksa (Cacat Fisik)', 'deleted_disability' => '0'],
            ['id_disability' => 5, 'name_disability' => 'Tuna Laras (Cacat Pengendalian Diri)', 'deleted_disability' => '0'],
            ['id_disability' => 6, 'name_disability' => 'Tuna Grahita (Keterbelakangan Mental)', 'deleted_disability' => '0'],
            ['id_disability' => 7, 'name_disability' => 'Tuna Ganda (Cacat Kombinasi)', 'deleted_disability' => '0'],
        ]);

        DB::table('education_level')->insert([
            ['id_educationlevel' => 1, 'name_educationlevel' => 'SD', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 2, 'name_educationlevel' => 'SMP/SLTP', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 3, 'name_educationlevel' => 'SMA', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 4, 'name_educationlevel' => 'SMK', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 5, 'name_educationlevel' => 'Diploma', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 6, 'name_educationlevel' => 'S1', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 7, 'name_educationlevel' => 'S2', 'deleted_educationlevel' => '0'],
            ['id_educationlevel' => 8, 'name_educationlevel' => 'Doktor / S3', 'deleted_educationlevel' => '0'],
        ]);

        DB::table('job_field')->insert([
            ['id_jobfield' => 3, 'name_jobfield' => 'Akuntansi / Keuangan', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 5, 'name_jobfield' => 'Administrasi & Perkantoran', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 10, 'name_jobfield' => 'Otomotif & Mekanik', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 15, 'name_jobfield' => 'Hukum / Legal', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 16, 'name_jobfield' => 'Human Resources (SDM)', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 17, 'name_jobfield' => 'Hotel & Restoran', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 21, 'name_jobfield' => 'IT & Software', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 25, 'name_jobfield' => 'Konstruksi & Teknik Sipil', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 28, 'name_jobfield' => 'Manufaktur & Produksi', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 29, 'name_jobfield' => 'Pelayanan Kesehatan', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 30, 'name_jobfield' => 'Pemasaran & Penjualan', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 49, 'name_jobfield' => 'Desain Grafis & Media Kreatif', 'deleted_jobfield' => '0'],
            ['id_jobfield' => 58, 'name_jobfield' => 'Customer Service', 'deleted_jobfield' => '0'],
        ]);

        DB::table('sub_job_field')->insert([
            ['id_subjobfield' => 1, 'name_subjobfield' => 'Akuntan & Pajak', 'id_job_field' => 3, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 2, 'name_subjobfield' => 'Staf Administrasi Umum', 'id_job_field' => 5, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 3, 'name_subjobfield' => 'Teknisi Otomotif', 'id_job_field' => 10, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 4, 'name_subjobfield' => 'Legal Officer', 'id_job_field' => 15, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 5, 'name_subjobfield' => 'HR Recruitment & Industrial Relation', 'id_job_field' => 16, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 6, 'name_subjobfield' => 'Web & Software Developer', 'id_job_field' => 21, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 7, 'name_subjobfield' => 'System & Network Administrator', 'id_job_field' => 21, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 8, 'name_subjobfield' => 'Site Engineer & Pengawas Proyek', 'id_job_field' => 25, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 9, 'name_subjobfield' => 'Operator Mesin & QC', 'id_job_field' => 28, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 10, 'name_subjobfield' => 'Digital Marketing & Sales', 'id_job_field' => 30, 'deleted_subjobfield' => '0'],
            ['id_subjobfield' => 11, 'name_subjobfield' => 'UI/UX & Desainer Grafis', 'id_job_field' => 49, 'deleted_subjobfield' => '0'],
        ]);

        DB::table('skill')->insert([
            ['id_skill' => 1, 'name_skill' => 'Microsoft Office', 'deleted_skill' => '0'],
            ['id_skill' => 2, 'name_skill' => 'Laravel & PHP', 'deleted_skill' => '0'],
            ['id_skill' => 3, 'name_skill' => 'Akuntansi & Perpajakan', 'deleted_skill' => '0'],
            ['id_skill' => 4, 'name_skill' => 'Digital Marketing', 'deleted_skill' => '0'],
            ['id_skill' => 5, 'name_skill' => 'Desain Grafis (Figma/Corel/Adobe)', 'deleted_skill' => '0'],
            ['id_skill' => 6, 'name_skill' => 'Las Listrik & SMAW', 'deleted_skill' => '0'],
            ['id_skill' => 7, 'name_skill' => 'Bahasa Inggris Aktif', 'deleted_skill' => '0'],
            ['id_skill' => 8, 'name_skill' => 'Administrasi Ketenagakerjaan & HRIS', 'deleted_skill' => '0'],
            ['id_skill' => 9, 'name_skill' => 'K3 Umum / Keselamatan Kerja', 'deleted_skill' => '0'],
            ['id_skill' => 10, 'name_skill' => 'Customer Service & Komunikasi', 'deleted_skill' => '0'],
        ]);

        DB::table('school')->insert([
            ['id_school' => 1, 'name_school' => 'SMA Negeri 1 Medan', 'education_level_id' => 3, 'deleted_school' => '0'],
            ['id_school' => 2, 'name_school' => 'SMA Negeri 2 Medan', 'education_level_id' => 3, 'deleted_school' => '0'],
            ['id_school' => 3, 'name_school' => 'SMK Negeri 1 Medan', 'education_level_id' => 4, 'deleted_school' => '0'],
            ['id_school' => 4, 'name_school' => 'SMK Negeri 2 Medan', 'education_level_id' => 4, 'deleted_school' => '0'],
            ['id_school' => 5, 'name_school' => 'SMK Telkom Medan', 'education_level_id' => 4, 'deleted_school' => '0'],
        ]);

        DB::table('university')->insert([
            ['id_university' => 1, 'name_university' => 'Universitas Sumatera Utara (USU)', 'deleted_university' => '0'],
            ['id_university' => 2, 'name_university' => 'Universitas Negeri Medan (UNIMED)', 'deleted_university' => '0'],
            ['id_university' => 3, 'name_university' => 'Politeknik Negeri Medan (POLMED)', 'deleted_university' => '0'],
            ['id_university' => 4, 'name_university' => 'Universitas Islam Negeri Sumatera Utara (UINSU)', 'deleted_university' => '0'],
            ['id_university' => 5, 'name_university' => 'Universitas Muhammadiyah Sumatera Utara (UMSU)', 'deleted_university' => '0'],
            ['id_university' => 6, 'name_university' => 'Universitas Mikroskil Medan', 'deleted_university' => '0'],
        ]);

        DB::table('major')->insert([
            ['id_major' => 1, 'name_major' => 'Teknik Informatika', 'deleted_major' => '0'],
            ['id_major' => 2, 'name_major' => 'Akuntansi', 'deleted_major' => '0'],
            ['id_major' => 3, 'name_major' => 'Manajemen', 'deleted_major' => '0'],
            ['id_major' => 4, 'name_major' => 'Teknik Mesin', 'deleted_major' => '0'],
            ['id_major' => 5, 'name_major' => 'Ilmu Hukum', 'deleted_major' => '0'],
        ]);

        DB::table('jabatan')->insert([
            ['id' => 1, 'name' => 'Staff Administrasi', 'deleted_jabatan' => 0, 'created_by' => 1],
            ['id' => 2, 'name' => 'Software Engineer', 'deleted_jabatan' => 0, 'created_by' => 1],
            ['id' => 3, 'name' => 'Supervisor Produksi', 'deleted_jabatan' => 0, 'created_by' => 1],
            ['id' => 4, 'name' => 'HR & GA Officer', 'deleted_jabatan' => 0, 'created_by' => 1],
            ['id' => 5, 'name' => 'Teknisi Lapangan', 'deleted_jabatan' => 0, 'created_by' => 1],
        ]);

        DB::table('sector_potential')->insert([
            ['id_sector' => 1, 'name_sector' => 'Pertanian', 'deleted_sector' => '0'],
            ['id_sector' => 2, 'name_sector' => 'Perkebunan', 'deleted_sector' => '0'],
            ['id_sector' => 3, 'name_sector' => 'Peternakan', 'deleted_sector' => '0'],
            ['id_sector' => 4, 'name_sector' => 'Perikanan', 'deleted_sector' => '0'],
            ['id_sector' => 5, 'name_sector' => 'Pertambangan', 'deleted_sector' => '0'],
            ['id_sector' => 6, 'name_sector' => 'Pariwisata', 'deleted_sector' => '0'],
            ['id_sector' => 7, 'name_sector' => 'Kesehatan', 'deleted_sector' => '0'],
            ['id_sector' => 8, 'name_sector' => 'Sumber Daya Manusia', 'deleted_sector' => '0'],
            ['id_sector' => 9, 'name_sector' => 'Manufaktur', 'deleted_sector' => '0'],
        ]);

        DB::table('vocational')->insert([
            ['id_vocational' => 1, 'name_vocational' => 'Teknik Manufaktur', 'deleted_vocational' => '0'],
            ['id_vocational' => 2, 'name_vocational' => 'Teknik Las', 'deleted_vocational' => '0'],
            ['id_vocational' => 3, 'name_vocational' => 'Bangunan', 'deleted_vocational' => '0'],
            ['id_vocational' => 4, 'name_vocational' => 'Teknik Listrik', 'deleted_vocational' => '0'],
            ['id_vocational' => 5, 'name_vocational' => 'Teknik Elektronika', 'deleted_vocational' => '0'],
            ['id_vocational' => 6, 'name_vocational' => 'Teknologi Informasi dan Komunikasi', 'deleted_vocational' => '0'],
            ['id_vocational' => 8, 'name_vocational' => 'Pariwisata', 'deleted_vocational' => '0'],
            ['id_vocational' => 9, 'name_vocational' => 'Tata Busana', 'deleted_vocational' => '0'],
            ['id_vocational' => 14, 'name_vocational' => 'Bisnis dan Manajemen', 'deleted_vocational' => '0'],
            ['id_vocational' => 16, 'name_vocational' => 'Teknik Otomotif', 'deleted_vocational' => '0'],
            ['id_vocational' => 18, 'name_vocational' => 'Tata Boga', 'deleted_vocational' => '0'],
            ['id_vocational' => 22, 'name_vocational' => 'Barista', 'deleted_vocational' => '0'],
            ['id_vocational' => 31, 'name_vocational' => 'Digital Marketing', 'deleted_vocational' => '0'],
        ]);

        DB::table('list_dispute_category')->insert([
            ['id' => 1, 'nama' => 'Perselisihan Hak dan Kewajiban', 'deleted' => 0],
            ['id' => 2, 'nama' => 'Perselisihan Kepentingan', 'deleted' => 0],
            ['id' => 3, 'nama' => 'Perselisihan Pemutusan Hubungan Kerja (PHK)', 'deleted' => 0],
            ['id' => 4, 'nama' => 'Perselisihan Antar Serikat Pekerja / Serikat Buruh', 'deleted' => 0],
        ]);

        DB::table('faq_category')->insert([
            ['id' => 1, 'name' => 'Kartu Kuning (AK-1)', 'deleted' => 0],
            ['id' => 2, 'name' => 'Sertifikasi', 'deleted' => 0],
            ['id' => 3, 'name' => 'Karir Hub / Lowongan', 'deleted' => 0],
            ['id' => 4, 'name' => 'Pelatihan', 'deleted' => 0],
            ['id' => 5, 'name' => 'Magang', 'deleted' => 0],
            ['id' => 8, 'name' => 'Pesangon & Perselisihan HI', 'deleted' => 0],
            ['id' => 11, 'name' => 'BPJS & WLKP', 'deleted' => 0],
        ]);

        DB::table('survey_services')->insert([
            ['id' => 1, 'name' => 'Pencari Kerja', 'created_by' => 1],
            ['id' => 2, 'name' => 'Perusahaan', 'created_by' => 1],
            ['id' => 3, 'name' => 'LPK', 'created_by' => 1],
        ]);

        DB::table('survey_questions')->insert([
            ['id' => 1, 'questioner' => 'Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?', 'label_name_1' => 'Tidak sesuai', 'label_name_2' => 'Kurang sesuai', 'label_name_3' => 'Sesuai', 'label_name_4' => 'Sangat sesuai', 'is_active' => 1],
            ['id' => 2, 'questioner' => 'Bagaimana pemahaman Saudara tentang kemudahan prosedur pelayanan di Dinas Ketenagakerjaan Kota Medan?', 'label_name_1' => 'Tidak mudah', 'label_name_2' => 'Kurang mudah', 'label_name_3' => 'Mudah', 'label_name_4' => 'Sangat mudah', 'is_active' => 1],
            ['id' => 3, 'questioner' => 'Bagaimana pendapat Saudara tentang kecepatan waktu dalam memberikan pelayanan?', 'label_name_1' => 'Tidak cepat', 'label_name_2' => 'Kurang cepat', 'label_name_3' => 'Cepat', 'label_name_4' => 'Sangat cepat', 'is_active' => 1],
            ['id' => 4, 'questioner' => 'Bagaimana pendapat Saudara tentang kewajaran biaya/tarif dalam pelayanan?', 'label_name_1' => 'Sangat mahal', 'label_name_2' => 'Cukup mahal', 'label_name_3' => 'Murah', 'label_name_4' => 'Gratis', 'is_active' => 1],
            ['id' => 5, 'questioner' => 'Bagaimana pendapat Saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang diberikan?', 'label_name_1' => 'Tidak sesuai', 'label_name_2' => 'Kurang sesuai', 'label_name_3' => 'Sesuai', 'label_name_4' => 'Sangat sesuai', 'is_active' => 1],
            ['id' => 6, 'questioner' => 'Bagaimana pendapat Saudara tentang kompetensi/kemampuan petugas dalam pelayanan?', 'label_name_1' => 'Tidak kompeten', 'label_name_2' => 'Kurang kompeten', 'label_name_3' => 'Kompeten', 'label_name_4' => 'Sangat kompeten', 'is_active' => 1],
            ['id' => 7, 'questioner' => 'Bagaimana pendapat Saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?', 'label_name_1' => 'Tidak sopan dan ramah', 'label_name_2' => 'Kurang sopan dan ramah', 'label_name_3' => 'Sopan dan ramah', 'label_name_4' => 'Sangat sopan dan ramah', 'is_active' => 1],
            ['id' => 8, 'questioner' => 'Bagaimana pendapat Saudara tentang kualitas sarana dan prasarana?', 'label_name_1' => 'Buruk', 'label_name_2' => 'Cukup', 'label_name_3' => 'Baik', 'label_name_4' => 'Sangat baik', 'is_active' => 1],
            ['id' => 9, 'questioner' => 'Bagaimana pendapat Saudara tentang penanganan pengaduan pengguna layanan?', 'label_name_1' => 'Tidak ada', 'label_name_2' => 'Ada tetapi tidak berfungsi', 'label_name_3' => 'Berfungsi kurang maksimal', 'label_name_4' => 'Dikelola dengan baik', 'is_active' => 1],
        ]);
    }
}
