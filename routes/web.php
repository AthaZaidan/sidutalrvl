<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\Ak1ManagementController;
use App\Http\Controllers\Admin\CertificationManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DisputeManagementController;
use App\Http\Controllers\Admin\FaqManagementController;
use App\Http\Controllers\Admin\InternshipManagementController;
use App\Http\Controllers\Admin\JobVacancyManagementController;
use App\Http\Controllers\Admin\LpkReportController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PelayananController;
use App\Http\Controllers\Admin\PlacementController;
use App\Http\Controllers\Admin\RegisterVerificationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SurveyManagementController;
use App\Http\Controllers\Admin\TrainingManagementController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\CompanyAuthController;
use App\Http\Controllers\Auth\JobseekerAuthController;
use App\Http\Controllers\Auth\LpkAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\Company\FindJobseekerController;
use App\Http\Controllers\Company\IndustrialRelationController;
use App\Http\Controllers\Company\InternshipController as CompanyInternshipController;
use App\Http\Controllers\Company\JobVacancyController as CompanyJobVacancyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Jobseeker\Ak1Controller;
use App\Http\Controllers\Jobseeker\DashboardController as JobseekerDashboardController;
use App\Http\Controllers\Lpk\CertificationController as LpkCertificationController;
use App\Http\Controllers\Lpk\DashboardController as LpkDashboardController;
use App\Http\Controllers\Lpk\InternshipController as LpkInternshipController;
use App\Http\Controllers\Lpk\ReportController as LpkReportSubmitController;
use App\Http\Controllers\Lpk\TrainingController as LpkTrainingController;
use App\Http\Controllers\Main\DisputeController;
use App\Http\Controllers\Main\FaqController;
use App\Http\Controllers\Main\InfoController;
use App\Http\Controllers\Main\InternshipController;
use App\Http\Controllers\Main\JobVacancyController;
use App\Http\Controllers\Main\NotificationController;
use App\Http\Controllers\Main\SurveyController;
use App\Http\Controllers\Main\TrainingController;
use App\Support\SidutaConstants;
use Illuminate\Support\Facades\Route;

// Public Portal
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// AJAX Reference Endpoints
Route::prefix('ajax')->name('ajax.')->group(function () {
    Route::get('/sub-job-fields', [HomeController::class, 'subJobFields'])->name('sub_job_fields');
    Route::get('/skills', [HomeController::class, 'skills'])->name('skills');
    Route::get('/schools', [HomeController::class, 'schools'])->name('schools');
    Route::get('/cities', [HomeController::class, 'cities'])->name('cities');
});

// Main Public Modules
Route::prefix('main')->name('main.')->group(function () {
    Route::get('/job_vacancy', [JobVacancyController::class, 'index'])->name('job_vacancy.index');
    Route::get('/job_vacancy/detail/{id}', [JobVacancyController::class, 'detail'])->name('job_vacancy.detail');
    Route::post('/job_vacancy/apply/{id}', [JobVacancyController::class, 'apply'])->name('job_vacancy.apply');

    Route::get('/internship', [InternshipController::class, 'index'])->name('internship.index');
    Route::get('/internship/detail/{id}', [InternshipController::class, 'detail'])->name('internship.detail');
    Route::post('/internship/apply/{id}', [InternshipController::class, 'apply'])->name('internship.apply');

    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/training/detail/{id}', [TrainingController::class, 'detail'])->name('training.detail');
    Route::post('/training/apply/{id}', [TrainingController::class, 'apply'])->name('training.apply');

    Route::get('/dispute', [DisputeController::class, 'index'])->name('dispute.index');
    Route::post('/dispute', [DisputeController::class, 'store'])->name('dispute.store');

    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
    Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');

    Route::get('/jdih', [InfoController::class, 'jdih'])->name('jdih');
    Route::get('/certificate', [InfoController::class, 'certificate'])->name('certificate.index');
    Route::get('/manual/download/{type}', [InfoController::class, 'downloadManual'])->name('manual.download');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/summary', [NotificationController::class, 'summary'])->name('notifications.summary');
});

// Shared Forgot/Reset Password (Pencaker / Perusahaan / LPK)
Route::get('/forgetpassword', [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgetpassword', [PasswordResetController::class, 'sendResetToken'])->name('password.forgot.submit');
Route::get('/editpassword', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/editpassword', [PasswordResetController::class, 'reset'])->name('password.reset.submit');

// Jobseeker Auth & Portal
Route::prefix('jobseeker')->name('jobseeker.')->group(function () {
    Route::get('/login', [JobseekerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [JobseekerAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [JobseekerAuthController::class, 'logout'])->name('logout');

    Route::get('/register', [JobseekerAuthController::class, 'showRegisterStep1'])->name('register');
    Route::post('/register', [JobseekerAuthController::class, 'submitRegisterStep1'])->name('register.step1.submit');

    Route::middleware('jobseeker.auth')->group(function () {
        Route::get('/register/step2', [JobseekerAuthController::class, 'showRegisterStep2'])->name('register.step2');
        Route::post('/register/step2', [JobseekerAuthController::class, 'submitRegisterStep2'])->name('register.step2.submit');
        Route::get('/register/step3', [JobseekerAuthController::class, 'showRegisterStep3'])->name('register.step3');
        Route::post('/register/step3', [JobseekerAuthController::class, 'submitRegisterStep3'])->name('register.step3.submit');
        Route::get('/register/step4', [JobseekerAuthController::class, 'showRegisterStep4'])->name('register.step4');
        Route::post('/register/step4', [JobseekerAuthController::class, 'submitRegisterStep4'])->name('register.step4.submit');
        Route::get('/register/done', [JobseekerAuthController::class, 'showRegisterDone'])->name('register.done');

        Route::get('/dashboard', [JobseekerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [JobseekerDashboardController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [JobseekerDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile/update', [JobseekerDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/experience', [JobseekerDashboardController::class, 'storeExperience'])->name('experience.store');
        Route::delete('/experience/{id}', [JobseekerDashboardController::class, 'deleteExperience'])->name('experience.delete');
        Route::post('/language', [JobseekerDashboardController::class, 'storeLanguage'])->name('language.store');
        Route::post('/file', [JobseekerDashboardController::class, 'storeFile'])->name('file.store');

        Route::get('/ak1registration', [Ak1Controller::class, 'index'])->name('ak1.index');
        Route::post('/ak1registration', [Ak1Controller::class, 'store'])->name('ak1.store');
        Route::get('/ak1/cetak/{id}', [Ak1Controller::class, 'cetak'])->name('ak1.cetak');
    });
});

// Company Auth & Portal
Route::prefix('company')->name('company.')->group(function () {
    Route::get('/login', [CompanyAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CompanyAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [CompanyAuthController::class, 'logout'])->name('logout');

    Route::get('/register', [CompanyAuthController::class, 'showRegisterStep1'])->name('register');
    Route::post('/register', [CompanyAuthController::class, 'submitRegisterStep1'])->name('register.step1.submit');

    Route::middleware('company.auth')->group(function () {
        Route::get('/register/step2', [CompanyAuthController::class, 'showRegisterStep2'])->name('register.step2');
        Route::post('/register/step2', [CompanyAuthController::class, 'submitRegisterStep2'])->name('register.step2.submit');
        Route::get('/register/done', [CompanyAuthController::class, 'showRegisterDone'])->name('register.done');

        Route::get('/dashboard', [CompanyDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [CompanyDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [CompanyDashboardController::class, 'updateProfile'])->name('profile.update');

        Route::get('/job_vacancy', [CompanyJobVacancyController::class, 'index'])->name('job_vacancy.index');
        Route::get('/job_vacancy/create', [CompanyJobVacancyController::class, 'create'])->name('job_vacancy.create');
        Route::post('/job_vacancy', [CompanyJobVacancyController::class, 'store'])->name('job_vacancy.store');
        Route::get('/job_vacancy/{id}/edit', [CompanyJobVacancyController::class, 'edit'])->name('job_vacancy.edit');
        Route::post('/job_vacancy/{id}', [CompanyJobVacancyController::class, 'update'])->name('job_vacancy.update');
        Route::post('/job_vacancy/{id}/close', [CompanyJobVacancyController::class, 'close'])->name('job_vacancy.close');
        Route::get('/job_vacancy/{id}/applicants', [CompanyJobVacancyController::class, 'applicants'])->name('job_vacancy.applicants');
        Route::post('/applicant/{id}/status', [CompanyJobVacancyController::class, 'updateApplicantStatus'])->name('job_vacancy.applicant.status');
        Route::post('/applicant/{id}/call', [CompanyJobVacancyController::class, 'callApplicant'])->name('job_vacancy.applicant.call');

        Route::get('/internship', [CompanyInternshipController::class, 'index'])->name('internship.index');
        Route::get('/internship/create', [CompanyInternshipController::class, 'create'])->name('internship.create');
        Route::post('/internship', [CompanyInternshipController::class, 'store'])->name('internship.store');
        Route::get('/internship/{id}/applicants', [CompanyInternshipController::class, 'applicants'])->name('internship.applicants');
        Route::post('/internship/applicant/{id}/status', [CompanyInternshipController::class, 'updateApplicantStatus'])->name('internship.applicant.status');

        Route::get('/findjobseeker', [FindJobseekerController::class, 'index'])->name('findjobseeker.index');
        Route::get('/findjobseeker/{id}', [FindJobseekerController::class, 'show'])->name('findjobseeker.show');

        Route::get('/hi/karyawan', [IndustrialRelationController::class, 'karyawan'])->name('hi.karyawan');
        Route::post('/hi/karyawan', [IndustrialRelationController::class, 'storeKaryawan'])->name('hi.karyawan.store');
        Route::get('/hi/wlkp', [IndustrialRelationController::class, 'wlkp'])->name('hi.wlkp');
        Route::post('/hi/wlkp', [IndustrialRelationController::class, 'storeWlkp'])->name('hi.wlkp.store');
        Route::post('/hi/serikat', [IndustrialRelationController::class, 'storeSerikat'])->name('hi.serikat.store');
        Route::get('/hi/pelayanan', [IndustrialRelationController::class, 'pelayanan'])->name('hi.pelayanan');
        Route::post('/hi/pp', [IndustrialRelationController::class, 'storePp'])->name('hi.pp.store');
        Route::post('/hi/pkwt', [IndustrialRelationController::class, 'storePkwt'])->name('hi.pkwt.store');
        Route::post('/hi/pkb', [IndustrialRelationController::class, 'storePkb'])->name('hi.pkb.store');
    });
});

// LPK Auth & Portal
Route::prefix('lpk')->name('lpk.')->group(function () {
    Route::get('/login', [LpkAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [LpkAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LpkAuthController::class, 'logout'])->name('logout');

    Route::get('/register', [LpkAuthController::class, 'showRegisterStep1'])->name('register');
    Route::post('/register', [LpkAuthController::class, 'submitRegisterStep1'])->name('register.step1.submit');

    Route::middleware('lpk.auth')->group(function () {
        Route::get('/register/step2', [LpkAuthController::class, 'showRegisterStep2'])->name('register.step2');
        Route::post('/register/step2', [LpkAuthController::class, 'submitRegisterStep2'])->name('register.step2.submit');
        Route::get('/register/done', [LpkAuthController::class, 'showRegisterDone'])->name('register.done');

        Route::get('/dashboard', [LpkDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [LpkDashboardController::class, 'profile'])->name('profile');
        Route::post('/profile', [LpkDashboardController::class, 'updateProfile'])->name('profile.update');

        Route::get('/training', [LpkTrainingController::class, 'index'])->name('training.index');
        Route::get('/training/create', [LpkTrainingController::class, 'create'])->name('training.create');
        Route::post('/training', [LpkTrainingController::class, 'store'])->name('training.store');
        Route::get('/training/{id}/applicants', [LpkTrainingController::class, 'applicants'])->name('training.applicants');
        Route::post('/training/{id}/close', [LpkTrainingController::class, 'closeTraining'])->name('training.close');

        Route::get('/internship', [LpkInternshipController::class, 'index'])->name('internship.index');
        Route::get('/internship/create', [LpkInternshipController::class, 'create'])->name('internship.create');
        Route::post('/internship', [LpkInternshipController::class, 'store'])->name('internship.store');
        Route::get('/internship/{id}/applicants', [LpkInternshipController::class, 'applicants'])->name('internship.applicants');

        Route::get('/certification', [LpkCertificationController::class, 'index'])->name('certification.index');
        Route::post('/certification', [LpkCertificationController::class, 'store'])->name('certification.store');

        Route::get('/report', [LpkReportSubmitController::class, 'index'])->name('report.index');
        Route::post('/report/{section}', [LpkReportSubmitController::class, 'store'])->name('report.store');
    });
});

// Admin Backoffice Multi-Role
Route::prefix('adm')->name('adm.')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('forgot_password');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('forgot_password.submit');
    Route::get('/reset-password', [AdminAuthController::class, 'showResetPassword'])->name('reset_password');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset_password.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/administrator', [AdminDashboardController::class, 'index'])->name('administrator');

        Route::middleware('admin.role:' . SidutaConstants::SUPER_ADMIN . ',' . SidutaConstants::ADMIN_REG)->group(function () {
            Route::get('/administrator/role', [RoleController::class, 'index'])->name('administrator.role');
            Route::post('/administrator/role', [RoleController::class, 'store'])->name('administrator.role.store');
            Route::post('/administrator/role/toggle-access', [RoleController::class, 'toggleAccess'])->name('administrator.role.toggle_access');
            Route::post('/administrator/role/{id}', [RoleController::class, 'update'])->name('administrator.role.update');
            Route::delete('/administrator/role/{id}', [RoleController::class, 'destroy'])->name('administrator.role.destroy');
            Route::get('/administrator/roleaccess/{id}', [RoleController::class, 'access'])->name('administrator.roleaccess');

            Route::get('/settings', [MenuController::class, 'index'])->name('settings.menu');
            Route::post('/settings/menu', [MenuController::class, 'storeMenu'])->name('settings.menu.store');
            Route::get('/settings/submenu', [MenuController::class, 'submenus'])->name('settings.submenu');
            Route::post('/settings/submenu', [MenuController::class, 'storeSubmenu'])->name('settings.submenu.store');
            Route::post('/settings/submenu/{id}/toggle', [MenuController::class, 'toggleSubmenu'])->name('settings.submenu.toggle');
        });

        // User Profile & Notifications
        Route::get('/user', [UserProfileController::class, 'index'])->name('user.index');
        Route::get('/user/edit', [UserProfileController::class, 'edit'])->name('user.edit');
        Route::post('/user/edit', [UserProfileController::class, 'update'])->name('user.update');
        Route::get('/user/changepassword', [UserProfileController::class, 'changePasswordForm'])->name('user.changepassword');
        Route::post('/user/changepassword', [UserProfileController::class, 'updatePassword'])->name('user.changepassword.update');
        Route::get('/user/notifications-json', [UserProfileController::class, 'notificationsJson'])->name('user.notifications.json');
        Route::get('/notifications', [UserProfileController::class, 'notifications'])->name('notifications.index');

        // Accounts & Registration Verification
        Route::get('/akun/user_account', [AccountController::class, 'index'])->name('account.index');
        Route::get('/management/account', [AccountController::class, 'index'])->name('management.account');
        Route::post('/akun/staff', [AccountController::class, 'storeStaff'])->name('account.staff.store');
        Route::post('/akun/user/{id}/toggle', [AccountController::class, 'toggleUser'])->name('account.user.toggle');
        Route::post('/akun/company/{id}/toggle', [AccountController::class, 'toggleCompany'])->name('account.company.toggle');
        Route::post('/akun/lpk/{id}/toggle', [AccountController::class, 'toggleLpk'])->name('account.lpk.toggle');

        Route::middleware('admin.role:' . SidutaConstants::ADMIN_REG . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS . ',' . SidutaConstants::ADMIN_SEKRETARIAT . ',' . SidutaConstants::PENGANTAR_KERJA)->group(function () {
            Route::get('/registrasi', [RegisterVerificationController::class, 'jobseekers'])->name('registrasi.jobseekers');
            Route::get('/registrasi/perusahaan', [RegisterVerificationController::class, 'companies'])->name('registrasi.companies');
            Route::get('/registrasi/lpk', [RegisterVerificationController::class, 'lpks'])->name('registrasi.lpks');
            Route::get('/management/register', [RegisterVerificationController::class, 'companies'])->name('management.register');
            Route::post('/registrasi/company/{id}/verify', [RegisterVerificationController::class, 'verifyCompany'])->name('registrasi.company.verify');
            Route::post('/registrasi/lpk/{id}/verify', [RegisterVerificationController::class, 'verifyLpk'])->name('registrasi.lpk.verify');
        });

        // Management Workflows
        Route::prefix('management')->name('management.')->group(function () {
            Route::middleware('admin.role:' . SidutaConstants::KABID_PENTA . ',' . SidutaConstants::PENGANTAR_KERJA . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS . ',' . SidutaConstants::ADMIN_SEKRETARIAT)->group(function () {
                Route::get('/job_vacancy', [JobVacancyManagementController::class, 'index'])->name('job_vacancy.index');
                Route::get('/job_vacancy/{id}', [JobVacancyManagementController::class, 'show'])->name('job_vacancy.show');
                Route::post('/job_vacancy/{id}/approve', [JobVacancyManagementController::class, 'approve'])->name('job_vacancy.approve');
                Route::post('/job_vacancy/{id}/decline', [JobVacancyManagementController::class, 'decline'])->name('job_vacancy.decline');
            });

            Route::middleware('admin.role:' . SidutaConstants::KABID_LATTAS . ',' . SidutaConstants::INSTRUKTUR_PRODUKTIVITAS . ',' . SidutaConstants::ADMIN_LATTAS . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS)->group(function () {
                Route::get('/internship', [InternshipManagementController::class, 'index'])->name('internship.index');
                Route::post('/internship/{id}/approve', [InternshipManagementController::class, 'approve'])->name('internship.approve');
                Route::post('/internship/{id}/decline', [InternshipManagementController::class, 'decline'])->name('internship.decline');
            });

            Route::middleware('admin.role:' . SidutaConstants::KABID_LATTAS . ',' . SidutaConstants::INSTRUKTUR_PELATIHAN . ',' . SidutaConstants::ADMIN_LATTAS . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS)->group(function () {
                Route::get('/training', [TrainingManagementController::class, 'index'])->name('training.index');
                Route::post('/training/{id}/approve', [TrainingManagementController::class, 'approve'])->name('training.approve');
                Route::post('/training/{id}/decline', [TrainingManagementController::class, 'decline'])->name('training.decline');
            });

            Route::middleware('admin.role:' . SidutaConstants::ADMIN_LATTAS . ',' . SidutaConstants::INSTRUKTUR_SERTIFIKASI . ',' . SidutaConstants::KABID_LATTAS . ',' . SidutaConstants::KADIS)->group(function () {
                Route::get('/certification', [CertificationManagementController::class, 'index'])->name('certification.index');
                Route::get('/certification/{id}', [CertificationManagementController::class, 'show'])->name('certification.show');
                Route::post('/certification/{id}/advance', [CertificationManagementController::class, 'advance'])->name('certification.advance');
                Route::post('/certification/{id}/reject', [CertificationManagementController::class, 'reject'])->name('certification.reject');
            });

            Route::middleware('admin.role:' . SidutaConstants::ADMIN_PENTA . ',' . SidutaConstants::KABID_PENTA . ',' . SidutaConstants::PENGANTAR_KERJA . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS)->group(function () {
                Route::get('/ak_1', [Ak1ManagementController::class, 'index'])->name('ak1.index');
                Route::get('/ak_1/{id}', [Ak1ManagementController::class, 'show'])->name('ak1.show');
                Route::post('/ak_1/{id}/validate', [Ak1ManagementController::class, 'validateAk1'])->name('ak1.validate');
                Route::post('/ak_1/{id}/decline', [Ak1ManagementController::class, 'decline'])->name('ak1.decline');
                Route::get('/ak_1/{id}/cetak', [Ak1ManagementController::class, 'cetak'])->name('ak1.cetak');
            });

            Route::middleware('admin.role:' . SidutaConstants::ADMIN_PSP . ',' . SidutaConstants::MEDIATOR . ',' . SidutaConstants::KABID_PSP . ',' . SidutaConstants::KABID_HI . ',' . SidutaConstants::KADIS . ',' . SidutaConstants::SEKRETARIS)->group(function () {
                Route::get('/dispute', [DisputeManagementController::class, 'index'])->name('dispute.index');
                Route::get('/dispute/{id}', [DisputeManagementController::class, 'show'])->name('dispute.show');
                Route::post('/dispute/{id}/process', [DisputeManagementController::class, 'process'])->name('dispute.process');
            });

            Route::middleware('admin.role:' . SidutaConstants::ADMIN_HUB_INDUSTRIAL . ',' . SidutaConstants::KABID_HI . ',' . SidutaConstants::MEDIATOR . ',' . SidutaConstants::BPJS_KETENAGAKERJAAN . ',' . SidutaConstants::BPJS_KESEHATAN . ',' . SidutaConstants::KADIS)->group(function () {
                Route::get('/pelayanan', [PelayananController::class, 'index'])->name('pelayanan.index');
                Route::post('/pelayanan/{type}/{id}/verify', [PelayananController::class, 'verify'])->name('pelayanan.verify');
            });

            Route::get('/report/lpk', [LpkReportController::class, 'index'])->name('report.lpk');
            Route::post('/report/lpk/{id}/lock', [LpkReportController::class, 'toggleLock'])->name('report.lpk.lock');

            Route::get('/survey', [SurveyManagementController::class, 'index'])->name('survey.index');
            Route::post('/survey/question', [SurveyManagementController::class, 'storeQuestion'])->name('survey.question.store');

            Route::get('/placement', [PlacementController::class, 'index'])->name('placement.index');
            Route::post('/placement/tkdn', [PlacementController::class, 'storeTkdn'])->name('placement.tkdn.store');
            Route::post('/placement/tka', [PlacementController::class, 'storeTka'])->name('placement.tka.store');

            Route::get('/faq', [FaqManagementController::class, 'index'])->name('faq.index');
            Route::post('/faq', [FaqManagementController::class, 'store'])->name('faq.store');
            Route::post('/faq/category', [FaqManagementController::class, 'storeCategory'])->name('faq.category.store');
            Route::delete('/faq/{id}', [FaqManagementController::class, 'destroy'])->name('faq.destroy');
        });

        // Master Data (16 types)
        Route::prefix('data')->name('data.')->group(function () {
            Route::get('/notification', [MasterDataController::class, 'notificationAccess'])->name('notification');
            Route::post('/notification', [MasterDataController::class, 'storeNotificationAccess'])->name('notification.store');

            Route::get('/{type}', [MasterDataController::class, 'index'])->name('index');
            Route::post('/{type}', [MasterDataController::class, 'store'])->name('store');
            Route::post('/{type}/{id}', [MasterDataController::class, 'update'])->name('update');
            Route::delete('/{type}/{id}', [MasterDataController::class, 'destroy'])->name('destroy');
        });
    });
});
