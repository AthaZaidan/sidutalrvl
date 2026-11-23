<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->increments('id_role');
            $table->string('role', 128);
        });

        Schema::create('user_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu', 128);
            $table->integer('position')->default(1);
        });

        Schema::create('user_sub_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->index();
            $table->string('title', 128);
            $table->string('url', 128);
            $table->string('icon', 256)->default('fas fa-circle');
            $table->integer('is_active')->default(1);
        });

        Schema::create('user_access_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->index();
            $table->integer('menu_id')->index();
        });

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 128);
            $table->string('last_name', 128)->nullable();
            $table->string('email', 128)->unique('user_email');
            $table->string('image', 128)->default('default.jpg');
            $table->string('password', 256);
            $table->string('gender', 20)->nullable();
            $table->date('dob')->nullable();
            $table->string('no_handphone', 32)->nullable();
            $table->text('address')->nullable();
            $table->string('place_birth', 256)->nullable();
            $table->string('religion', 256)->nullable();
            $table->string('status', 256)->nullable();
            $table->string('district', 128)->nullable();
            $table->integer('job_field')->nullable();
            $table->integer('sub_job_field')->nullable();
            $table->integer('education_level')->nullable();
            $table->integer('educational_institutions')->nullable();
            $table->string('major', 64)->nullable();
            $table->date('start_period')->nullable();
            $table->string('end_period', 4)->nullable();
            $table->float('ipk')->nullable();
            $table->string('nik', 16)->nullable();
            $table->longText('result')->nullable();
            $table->integer('reg_status')->default(0);
            $table->integer('role_id')->default(14);
            $table->integer('is_active')->default(0);
            $table->integer('date_create')->default(0);
            $table->timestamp('created_user')->useCurrent();
            $table->string('deleted_user', 1)->default('0');
            $table->string('no_wa', 15)->nullable();
            $table->index(['job_field', 'sub_job_field', 'education_level', 'educational_institutions'], 'user_job_edu_idx');
        });

        Schema::create('user_token', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 128)->index();
            $table->string('token', 128);
            $table->integer('date_created');
            $table->integer('type')->nullable();
        });

        Schema::create('company', function (Blueprint $table) {
            $table->increments('id_company');
            $table->string('name_company', 256)->nullable();
            $table->string('address_company', 256)->nullable();
            $table->string('email_company', 128)->index();
            $table->string('password_company', 256);
            $table->string('logo_company', 256)->nullable();
            $table->integer('category_company')->nullable()->index();
            $table->integer('badanusaha_company')->nullable()->index();
            $table->string('hp_company', 128)->default('');
            $table->string('pj_company', 128)->default('');
            $table->string('npwp_company', 128)->nullable();
            $table->string('nib_company', 128)->nullable();
            $table->string('akta_company', 128)->nullable();
            $table->string('legal_status', 1)->default('0');
            $table->string('cp_penanggungjawab', 128)->default('');
            $table->string('cp_direktur', 128)->nullable();
            $table->integer('is_activecompany')->default(1);
            $table->integer('status_regcompany')->default(0);
            $table->timestamp('created_company')->useCurrent();
            $table->string('deleted_company', 1)->default('0');
            $table->string('name_direktur', 255)->nullable()->default('');
            $table->string('jabatan_pj', 255)->nullable()->default('');
        });

        Schema::create('company_backup_archive_deleted', function (Blueprint $table) {
            $table->integer('id_company')->default(0);
            $table->string('name_company', 256)->nullable();
            $table->string('address_company', 256)->nullable();
            $table->string('email_company', 128);
            $table->string('password_company', 256);
            $table->string('logo_company', 256)->nullable();
            $table->integer('category_company')->nullable();
            $table->integer('badanusaha_company')->nullable();
            $table->string('hp_company', 128)->default('');
            $table->string('pj_company', 128)->default('');
            $table->string('npwp_company', 128)->nullable();
            $table->string('nib_company', 128)->nullable();
            $table->string('akta_company', 128)->nullable();
            $table->string('legal_status', 1)->default('0');
            $table->string('cp_penanggungjawab', 128)->default('');
            $table->string('cp_direktur', 128)->nullable();
            $table->integer('is_activecompany')->default(1);
            $table->integer('status_regcompany')->default(0);
            $table->timestamp('created_company')->useCurrent();
            $table->string('deleted_company', 1)->default('0');
            $table->string('name_direktur', 255)->nullable()->default('');
            $table->string('jabatan_pj', 255)->nullable()->default('');
        });

        Schema::create('lpk', function (Blueprint $table) {
            $table->increments('id_lpk');
            $table->string('name_lpk', 128)->nullable();
            $table->string('name_leader', 128)->nullable();
            $table->string('email_lpk', 128)->index();
            $table->integer('role_id')->default(15);
            $table->string('password_lpk', 255);
            $table->string('address_lpk', 128)->nullable();
            $table->string('no_telp', 128)->nullable();
            $table->string('nohp_pimpinan', 128)->nullable();
            $table->date('year_lpk')->nullable();
            $table->string('no_vin', 128)->default('');
            $table->string('izin_lpk', 128)->nullable();
            $table->string('akreditasi_lpk', 128)->nullable();
            $table->integer('daya_tampung_lpk')->nullable();
            $table->integer('kbli_lpk')->nullable();
            $table->integer('legal_status')->nullable()->default(0);
            $table->integer('potential_sector_id')->nullable();
            $table->integer('exellent_vocational_id')->nullable();
            $table->string('logo_lpk', 128)->nullable()->default('default.png');
            $table->string('license_number', 25)->nullable();
            $table->string('certification_number', 25)->nullable();
            $table->integer('is_activelpk')->default(1);
            $table->timestamp('created_lpk')->useCurrent();
            $table->string('deleted_lpk', 1)->default('0');
            $table->string('no_izin_lpk', 100)->nullable();
            $table->string('no_akreditasi_lpk', 100)->nullable();
            $table->integer('count_staff')->nullable();
            $table->integer('bidangusaha_lpk')->nullable()->default(0);
            $table->integer('jenis_lpk')->nullable()->default(0);
            $table->string('namapj_lpk', 128)->nullable()->default('');
            $table->string('nopj_lpk', 128)->nullable()->default('');
            $table->string('jabatanpj_lpk', 128)->nullable()->default('');
        });

        Schema::create('lpk_listvocational', function (Blueprint $table) {
            $table->increments('id_listvocational');
            $table->integer('lpk_id')->index();
            $table->integer('vocational_id')->index();
        });

        Schema::create('subtypelist_notification', function (Blueprint $table) {
            $table->increments('id_listsubtype');
            $table->integer('id_subtype');
            $table->integer('role_id')->index();
            $table->timestamp('created_subtype')->useCurrent();
            $table->string('deleted_subtype', 1)->default('0');
        });

        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_log')->index();
            $table->string('action', 128);
            $table->timestamp('created')->useCurrent();
        });

        Schema::create('register_log', function (Blueprint $table) {
            $table->increments('id_log');
            $table->longText('name_log');
            $table->string('user_id', 128);
            $table->integer('adminreg_id');
            $table->timestamp('created_log')->useCurrent();
        });

        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip', 45);
            $table->date('date');
            $table->integer('hits')->default(1);
            $table->string('online', 255)->default('');
            $table->dateTime('time');
        });

        Schema::create('pelayanan_nik', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 50);
            $table->bigInteger('nik');
            $table->integer('approval')->default(0);
            $table->dateTime('created_date')->useCurrent();
            $table->dateTime('updated_date')->nullable();
            $table->longText('payload')->nullable();
        });
    }

    public function down(): void
    {
        foreach ([
            'pelayanan_nik', 'visitors', 'register_log', 'log', 'subtypelist_notification',
            'lpk_listvocational', 'lpk', 'company_backup_archive_deleted', 'company',
            'user_token', 'user', 'user_access_menu', 'user_sub_menu', 'user_menu', 'user_role',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
