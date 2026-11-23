<?php

namespace Tests\Feature;

use App\Models\Ak1;
use App\Models\Company;
use App\Models\Dispute;
use App\Models\JobField;
use App\Models\JobVacancy;
use App\Models\Lpk;
use App\Models\PermohonanPp;
use App\Models\Training;
use App\Models\User;
use App\Support\SidutaConstants;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SidutaMigrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_portal_pages_and_sqli_safe_filters(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Filter including SQL injection payload should safely return 200 without DB errors
        $this->get('/main/job_vacancy?job_filter=' . urlencode("' OR '1'='1"))
            ->assertOk();

        $this->get('/main/job_vacancy?job_filter=Laravel')
            ->assertOk()
            ->assertSee('Fullstack Web Developer (Laravel)');

        $this->get('/main/job_vacancy/detail/1')
            ->assertOk()
            ->assertSee('Fullstack Web Developer (Laravel)');

        $this->get('/main/internship')->assertOk()->assertSee('Magang UI/UX');
        $this->get('/main/internship/detail/1')->assertOk();
        $this->get('/main/training')->assertOk()->assertSee('Pelatihan Kompetensi Web Development');
        $this->get('/main/training/detail/1')->assertOk();
        $this->get('/main/faq')->assertOk()->assertSee('Kartu Kuning');
        $this->get('/main/jdih')->assertOk()->assertSee('Permenaker');
        $this->get('/main/certificate?code=SIDUTA-CERT-2026-0001')
            ->assertOk()
            ->assertSee('Sertifikat Terverifikasi Asli')
            ->assertSee('Budi Santoso');

        // Verify all 4 portal auth views render cleanly
        $this->get('/adm')->assertOk();
        $this->get('/adm/forgot-password')->assertOk();
        $this->get('/jobseeker/login')->assertOk();
        $this->get('/jobseeker/register')->assertOk();
        $this->get('/company/login')->assertOk();
        $this->get('/company/register')->assertOk();
        $this->get('/lpk/login')->assertOk();
        $this->get('/lpk/register')->assertOk();
        $this->get('/forgetpassword')->assertOk();
    }

    public function test_public_dispute_and_survey_ikm_submissions(): void
    {
        Storage::fake('public');

        $this->post('/main/dispute', [
            'title' => 'Perselisihan Hak dan Kewajiban',
            'description' => 'Pemotongan upah sepihak tanpa dasar.',
            'nama' => 'Siti Pelapor',
            'nik' => '1271011122334455',
            'email' => 'siti@example.test',
            'hp' => '081299998888',
            'alamat' => 'Jl. Setia Budi Medan',
            'company' => 'PT Uji Coba',
            'address_company' => 'Jl. Merdeka Medan',
            'evidence' => UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
        ])->assertRedirect();

        $this->assertDatabaseHas('dispute', [
            'nik' => '1271011122334455',
            'company' => 'PT Uji Coba',
            'status' => SidutaConstants::DISPUTE_SEND_BY_USER,
        ]);

        $this->get('/main/dispute?nik=1271011122334455')
            ->assertOk()
            ->assertSee('PT Uji Coba');

        $this->post('/main/survey', [
            'survey_service_id' => 1,
            'name' => 'Responden Uji',
            'age' => 27,
            'gender' => 'laki-laki',
            'education' => 'S1',
            'job' => 'Pencari Kerja',
            'saran' => 'Pelayanan cepat dan gratis.',
            'answers' => [1 => 4, 2 => 4, 3 => 4, 4 => 4, 5 => 4, 6 => 4, 7 => 4, 8 => 4, 9 => 4],
        ])->assertRedirect('/main/survey');

        $this->assertDatabaseHas('survey_responden_profiles', ['name' => 'Responden Uji']);
    }

    public function test_jobseeker_portal_ak1_qr_and_apply_job(): void
    {
        $this->post('/jobseeker/login', [
            'inputEmail' => 'pencaker@siduta.test',
            'inputPassword' => 'password',
        ])->assertRedirect('/jobseeker/dashboard');

        $this->get('/jobseeker/dashboard')->assertOk()->assertSee('Budi Santoso');
        $this->get('/jobseeker/profile')->assertOk()->assertSee('1271011405980001');

        // Print AK-1 with QR code SVG
        $this->get('/jobseeker/ak1/cetak/1')
            ->assertOk()
            ->assertSee('<svg', false)
            ->assertSee('AK1-000001');

        // Apply to published job #1
        $this->post('/main/job_vacancy/apply/1')->assertRedirect('/main/job_vacancy/detail/1');
        $this->assertDatabaseHas('list_applicantjv', [
            'jobvacancy_id' => 1,
            'user_id' => 16,
        ]);

        // Logout then test 4-step registration wizard for new jobseeker
        $this->post('/jobseeker/logout')->assertRedirect('/');
        $this->post('/jobseeker/register', [
            'first_name' => 'Dewi',
            'last_name' => 'Lestari',
            'email' => 'dewi.baru@siduta.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect('/jobseeker/register/step2');

        $this->post('/jobseeker/register/step2', [
            'nik' => '1271019988776655',
            'gender' => 'perempuan',
            'place_birth' => 'Medan',
            'dob' => '1999-02-02',
            'no_handphone' => '081234000111',
            'religion' => 'Islam',
            'status' => 'Belum Kawin',
            'district' => 'Medan Johor',
            'address' => 'Jl. Karya Wisata Medan',
        ])->assertRedirect('/jobseeker/register/step3');

        $this->post('/jobseeker/register/step3', [
            'job_field' => 21,
            'sub_job_field' => 6,
            'skills' => [1, 2],
        ])->assertRedirect('/jobseeker/register/step4');

        $this->post('/jobseeker/register/step4', [
            'education_level' => 6,
            'educational_institutions' => 1,
            'major' => 'Sistem Informasi',
            'end_period' => '2022',
            'ipk' => 3.75,
        ])->assertRedirect('/jobseeker/register/done');

        $this->assertDatabaseHas('user', [
            'email' => 'dewi.baru@siduta.test',
            'reg_status' => SidutaConstants::STATUS_REG_JSDONE,
        ]);
    }

    public function test_company_portal_job_and_hi_services(): void
    {
        $this->post('/company/login', [
            'inputEmail' => 'perusahaan@siduta.test',
            'inputPassword' => 'password',
        ])->assertRedirect('/company/dashboard');

        $this->get('/company/dashboard')->assertOk()->assertSee('Medan Teknologi Nusantara');

        $this->post('/company/job_vacancy', [
            'title_jobvacancy' => 'Backend Engineer Laravel 13',
            'jobfield_vacancy' => 21,
            'subjobfield_vacancy' => 6,
            'city_vacancy' => 1,
            'education_level' => 6,
            'experience_vacancy' => 2,
            'salary_start' => '6000000',
            'salary_end' => '9000000',
            'desc_vacancy' => '<p>Membangun API aman Laravel 13.</p>',
            'disability_status' => 0,
            'skills' => [2],
        ])->assertRedirect('/company/job_vacancy');

        $this->assertDatabaseHas('job_vacancy', ['title_jobvacancy' => 'Backend Engineer Laravel 13']);

        // HI services: Karyawan, WLKP, Serikat, PP, PKWT, PKB
        $this->post('/company/hi/karyawan', [
            'identity' => '1271010101900099',
            'nama' => 'Karyawan Uji',
            'sex' => 1,
            'tgl_lahir' => '1990-01-01',
            'tmpt_lahir' => 'Medan',
            'jabatan' => 'Staff IT',
            'education' => 6,
            'salary' => 5000000,
            'is_bpjs_tk' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('karyawan', ['identity' => '1271010101900099']);

        $this->post('/company/hi/wlkp', [
            'no_wlkp' => 'WLKP-2026-999',
            'tahun_wlkp' => '2026',
        ])->assertRedirect();
        $this->assertDatabaseHas('wlkp', ['no_wlkp' => 'WLKP-2026-999']);

        $this->post('/company/hi/serikat', [
            'nama_serikat' => 'SP Uji Medan',
            'no_serikat_reg' => 'REG-99',
            'jumlah_anggota' => 30,
        ])->assertRedirect();
        $this->assertDatabaseHas('serikat', ['nama_serikat' => 'SP Uji Medan']);

        $this->post('/company/hi/pp', [
            'npp' => 'NPP-TEST-002',
            'kode_badan_usaha' => 'BU-TEST-002',
            'nib' => '9120102939999',
            'status_modal_company' => 1,
            'bidang_usaha' => 'Teknologi',
            'tgl_surat_izin' => '2025-01-01',
            'upah_min' => 4000000,
            'upah_max' => 10000000,
        ])->assertRedirect();
        $this->assertDatabaseHas('permohonan_pp', ['npp' => 'NPP-TEST-002']);

        $this->post('/company/hi/pkwt', [
            'pemberi_kerja' => 'PT Medan Teknologi',
            'penerima_kerja' => 'Rudi Hartono',
            'npp' => 'NPP-PKWT-001',
            'kode_badan_usaha' => 'BU-PKWT-001',
        ])->assertRedirect();
        $this->assertDatabaseHas('permohonan_pkwt', ['npp' => 'NPP-PKWT-001']);

        $this->post('/company/hi/pkb', [
            'tahun_company' => '2026',
            'npp' => 'NPP-PKB-001',
            'kode_badan_usaha' => 'BU-PKB-001',
            'bidang_usaha' => 'Teknologi',
            'upah_min' => 4000000,
            'upah_max' => 12000000,
        ])->assertRedirect();
        $this->assertDatabaseHas('permohonan_pkb', ['npp' => 'NPP-PKB-001']);
    }

    public function test_lpk_portal_training_certification_and_semester_reports(): void
    {
        $this->post('/lpk/login', [
            'inputEmail' => 'lpk@siduta.test',
            'inputPassword' => 'password',
        ])->assertRedirect('/lpk/dashboard');

        $this->get('/lpk/dashboard')->assertOk()->assertSee('LPK Cerdas Karya Medan');

        $this->post('/lpk/training', [
            'title_training' => 'Pelatihan Las Listrik 2026',
            'city_training' => 1,
            'price_training' => '0',
            'method_training' => 1,
            'duration_training' => 20,
            'date_training' => now()->addDays(15)->toDateString(),
            'desc_training' => '<p>Pelatihan las bersertifikat.</p>',
        ])->assertRedirect('/lpk/training');
        $this->assertDatabaseHas('training', ['title_training' => 'Pelatihan Las Listrik 2026']);

        $this->post('/lpk/certification', [
            'name_certification' => 'Uji Kompetensi Las SMAW',
            'vocational_id' => 2,
            'totalh_certification' => 60,
            'date_certification' => now()->addDays(20)->toDateString(),
            'loc_certification' => 'Workshop LPK Medan',
            'participant_ids' => [16],
        ])->assertRedirect();
        $this->assertDatabaseHas('certification', ['name_certification' => 'Uji Kompetensi Las SMAW']);

        $this->post('/lpk/report/karyawan', [
            'sms' => 1,
            'yr1' => 2026,
            'tpt_lk' => 3,
            'tpt_p' => 2,
            'it_lk' => 4,
            'it_p' => 2,
        ])->assertRedirect();

        $this->post('/lpk/report/p2', [
            'sms' => 1,
            'yr1' => 2026,
            'nama_pelatihan' => 'Web Dev Batch 1',
            'jadwal_pelatihan' => '2026-06-01',
            'jumlah_pesertalat' => 25,
            'jumlah_lulusanlat' => 24,
            'jumlah_lulusanker' => 20,
            'jumlah_lulusanwir' => 4,
        ])->assertRedirect();
        $this->assertDatabaseHas('kegiatan_p2_lpk', ['nama_pelatihan' => 'Web Dev Batch 1']);
    }

    public function test_admin_multi_role_workflows_and_authorization(): void
    {
        // Guest protection
        $this->get('/adm/administrator')->assertRedirect('/adm');
        $this->get('/jobseeker/dashboard')->assertRedirect('/jobseeker/login');
        $this->get('/company/dashboard')->assertRedirect('/company/login');
        $this->get('/lpk/dashboard')->assertRedirect('/lpk/login');

        // Jobseeker cannot access admin backoffice
        $this->actingAs(User::find(16), 'web')
            ->get('/adm/administrator')
            ->assertRedirect('/adm');

        // Admin PSP cannot access Super Admin Role Management
        $this->actingAs(User::find(10), 'web')
            ->get('/adm/administrator/role')
            ->assertRedirect('/adm/user');

        // Super Admin dashboard, Role toggle-access, Master Data CRUD
        $this->post('/adm/login', [
            'inputEmail' => 'admin@siduta.test',
            'inputPassword' => 'password',
        ])->assertRedirect('/adm/administrator');

        $this->get('/adm/administrator')->assertOk()->assertSee('Dashboard SIDUTA Kota Medan');

        // Verify restructured admin management, settings, accounts, registrations, and master-data views
        foreach ([
            '/adm/administrator/role',
            '/adm/settings',
            '/adm/settings/submenu',
            '/adm/user',
            '/adm/user/edit',
            '/adm/user/changepassword',
            '/adm/notifications',
            '/adm/akun/user_account',
            '/adm/registrasi',
            '/adm/registrasi/perusahaan',
            '/adm/registrasi/lpk',
            '/adm/management/job_vacancy',
            '/adm/management/internship',
            '/adm/management/training',
            '/adm/management/certification',
            '/adm/management/ak_1',
            '/adm/management/dispute',
            '/adm/management/pelayanan',
            '/adm/management/report/lpk',
            '/adm/management/survey',
            '/adm/management/placement',
            '/adm/management/faq',
            '/adm/data/job_field',
            '/adm/data/notification',
        ] as $adminPath) {
            $this->get($adminPath)->assertOk();
        }

        $this->post('/adm/administrator/role/toggle-access', [
            'role_id' => SidutaConstants::ADMIN_REG,
            'menu_id' => 5,
        ])->assertRedirect();
        $this->assertDatabaseHas('user_access_menu', [
            'role_id' => SidutaConstants::ADMIN_REG,
            'menu_id' => 5,
        ]);

        $this->post('/adm/data/job_field', ['name' => 'Energi Terbarukan'])->assertRedirect();
        $jf = JobField::where('name_jobfield', 'Energi Terbarukan')->first();
        $this->assertNotNull($jf);

        $this->post('/adm/data/job_field/' . $jf->id_jobfield, ['name' => 'Energi Hijau'])->assertRedirect();
        $this->assertDatabaseHas('job_field', ['name_jobfield' => 'Energi Hijau']);

        $this->delete('/adm/data/job_field/' . $jf->id_jobfield)->assertRedirect();
        $this->assertDatabaseHas('job_field', ['id_jobfield' => $jf->id_jobfield, 'deleted_jobfield' => '1']);

        // AK-1 approval workflow: Admin Penta -> Pengantar Kerja
        $ak1 = Ak1::create([
            'user_id' => 16,
            'process_status' => SidutaConstants::AK1_SUBMITTED,
            'deleted_ak1' => 0,
        ]);
        $this->actingAs(User::find(2), 'web') // Admin Penta
            ->post('/adm/management/ak_1/' . $ak1->id_ak1 . '/validate')
            ->assertRedirect();
        $this->assertDatabaseHas('ak1', ['id_ak1' => $ak1->id_ak1, 'process_status' => SidutaConstants::AK1_ACCEPTED_PENTA]);

        $this->actingAs(User::find(3), 'web') // Pengantar Kerja
            ->post('/adm/management/ak_1/' . $ak1->id_ak1 . '/validate')
            ->assertRedirect();
        $this->assertDatabaseHas('ak1', ['id_ak1' => $ak1->id_ak1, 'process_status' => SidutaConstants::AK1_APPROVED]);

        // Job Vacancy approval workflow: Pengantar Kerja -> KABID PENTA
        $this->actingAs(User::find(3), 'web')
            ->post('/adm/management/job_vacancy/3/approve')
            ->assertRedirect();
        $this->assertDatabaseHas('job_vacancy', ['id_jobvacancy' => 3, 'process_status' => SidutaConstants::PROC_REVIEWED_OFFICER]);

        $this->actingAs(User::find(4), 'web') // KABID PENTA
            ->post('/adm/management/job_vacancy/3/approve')
            ->assertRedirect();
        $this->assertDatabaseHas('job_vacancy', ['id_jobvacancy' => 3, 'publish_status' => SidutaConstants::PUBLISHED]);

        // Dispute workflow: Admin PSP -> KABID HI -> Mediator -> Finish
        $dispute = Dispute::create([
            'title' => 'Perselisihan PHK',
            'description' => 'Pesangon belum dibayar',
            'status' => SidutaConstants::DISPUTE_SEND_BY_USER,
            'deleted' => 0,
            'user_created' => 16,
            'nama' => 'Budi',
            'company' => 'PT X',
        ]);

        $this->actingAs(User::find(10), 'web') // Admin PSP
            ->post('/adm/management/dispute/' . $dispute->id . '/process', ['action' => 'accept_psp'])
            ->assertRedirect();
        $this->actingAs(User::find(11), 'web') // KABID HI
            ->post('/adm/management/dispute/' . $dispute->id . '/process', ['action' => 'assign_mediator', 'mediator' => 12])
            ->assertRedirect();
        $this->actingAs(User::find(12), 'web') // Mediator
            ->post('/adm/management/dispute/' . $dispute->id . '/process', ['action' => 'solved', 'solving_description' => 'Tercapai perjanjian bersama'])
            ->assertRedirect();

        $this->assertDatabaseHas('dispute', [
            'id' => $dispute->id,
            'status' => SidutaConstants::DISPUTE_CLEARED_MEDIATOR,
        ]);

        // Pelayanan HI verification: BPJS TK -> KABID HI
        $this->actingAs(User::find(14), 'web') // BPJS TK
            ->post('/adm/management/pelayanan/pp/1/verify')
            ->assertRedirect();
        $this->assertDatabaseHas('permohonan_pp', ['id_pp' => 1, 'bpjs_tk_status' => 1]);

        $this->actingAs(User::find(11), 'web') // KABID HI
            ->post('/adm/management/pelayanan/pp/1/verify')
            ->assertRedirect();
        $this->assertDatabaseHas('permohonan_pp', ['id_pp' => 1, 'process_status' => SidutaConstants::HI_APPROVED]);
    }
}
