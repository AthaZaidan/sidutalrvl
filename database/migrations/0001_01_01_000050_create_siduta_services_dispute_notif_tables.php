<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispute', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 256);
            $table->string('description', 256);
            $table->string('evidence', 256)->nullable()->default('');
            $table->integer('status')->default(0);
            $table->string('solving_description', 500)->nullable();
            $table->integer('mediator')->nullable()->index();
            $table->timestamp('created')->useCurrent();
            $table->smallInteger('deleted')->default(0);
            $table->integer('user_created')->default(0);
            $table->string('nama', 100)->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('company', 100)->nullable()->default('');
            $table->text('address_company')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('closed_date')->nullable();
        });

        Schema::create('dispute_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_dispute')->index();
            $table->string('action', 500);
            $table->timestamp('created')->useCurrent();
        });

        Schema::create('faq', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->text('answer');
            $table->integer('id_category_faq')->index();
            $table->tinyInteger('category_user')->default(0);
            $table->tinyInteger('is_published')->default(1);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('updated')->useCurrent();
            $table->tinyInteger('deleted')->default(0);
        });

        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id_notif');
            $table->string('desc_notif', 255);
            $table->integer('user_id')->nullable()->index();
            $table->integer('company_id')->nullable();
            $table->integer('lpk_id')->nullable();
            $table->integer('jv_id')->nullable();
            $table->integer('train_id')->nullable();
            $table->integer('in_id')->nullable();
            $table->integer('cf_id')->nullable();
            $table->integer('ak1_id')->nullable();
            $table->string('status_reg', 1)->default('0');
            $table->string('status_read', 1)->default('0');
            $table->integer('subtype_notif')->nullable();
            $table->timestamp('created_notif')->useCurrent();
            $table->integer('dispute_id')->nullable();
        });

        Schema::create('client_notification', function (Blueprint $table) {
            $table->increments('id_notif');
            $table->text('desc_notif');
            $table->integer('app_id')->nullable();
            $table->integer('jobvacancy_id')->nullable();
            $table->integer('internship_id')->nullable();
            $table->integer('training_id')->nullable();
            $table->integer('user_id')->nullable()->index();
            $table->integer('company_id')->nullable()->index();
            $table->integer('lpk_id')->nullable()->index();
            $table->string('status_mute', 1)->default('0');
            $table->string('status_read', 1)->default('0');
            $table->timestamp('created_notif')->useCurrent();
            $table->string('deleted_notif', 1)->default('0');
        });

        Schema::create('karyawan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->string('identity', 100);
            $table->string('nama', 255);
            $table->tinyInteger('sex')->default(1);
            $table->date('tgl_lahir');
            $table->string('tmpt_lahir', 255);
            $table->string('jabatan', 255)->nullable();
            $table->unsignedInteger('education')->default(1);
            $table->tinyInteger('disabilitas')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->text('address')->nullable();
            $table->integer('salary')->default(0);
            $table->tinyInteger('is_tka')->default(0);
            $table->tinyInteger('is_bpjs_tk')->default(0);
            $table->tinyInteger('is_bpjs_kesehatan')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->string('no_hp', 20)->nullable();
            $table->text('notes_tk')->nullable();
            $table->tinyInteger('process_status')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->text('notes_kesehatan')->nullable();
        });

        Schema::create('wlkp', function (Blueprint $table) {
            $table->increments('id_wlkp');
            $table->integer('company_id')->index();
            $table->string('no_wlkp', 255);
            $table->string('tahun_wlkp', 4);
            $table->string('file_lampiran', 255)->default('');
            $table->dateTime('created_at')->useCurrent();
            $table->unsignedInteger('created_by')->default(1);
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });

        Schema::create('serikat', function (Blueprint $table) {
            $table->increments('id_serikat');
            $table->string('nama_serikat', 255);
            $table->unsignedInteger('company_id')->index();
            $table->string('no_serikat_reg', 100)->nullable();
            $table->text('address_serikat')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->dateTime('created_at')->useCurrent();
        });

        Schema::create('permohonan_pp', function (Blueprint $table) {
            $table->increments('id_pp');
            $table->unsignedInteger('company_id')->index();
            $table->string('npp', 255)->unique();
            $table->string('kode_badan_usaha', 255)->unique();
            $table->string('nib', 255)->unique();
            $table->tinyInteger('status_modal_company')->nullable();
            $table->string('bidang_usaha', 255);
            $table->date('tgl_surat_izin');
            $table->unsignedBigInteger('upah_min')->default(0);
            $table->unsignedBigInteger('upah_max')->default(0);
            $table->tinyInteger('has_sp_sb')->default(0);
            $table->string('file_naskah_pp', 255)->nullable();
            $table->string('struktur_skala_upah', 255)->nullable();
            $table->string('last_payment_bpjs', 255)->nullable();
            $table->string('last_pp_file', 255)->nullable();
            $table->string('surat_permohonan', 255)->nullable();
            $table->string('final_pp_file', 255)->nullable();
            $table->tinyInteger('process_status')->default(0);
            $table->integer('bpjs_tk_status')->default(0);
            $table->integer('mediator_status')->default(0);
            $table->integer('bpjs_ks_status')->default(0);
            $table->unsignedTinyInteger('pembetulan_ke')->default(0);
            $table->text('decline_reason')->nullable();
            $table->unsignedInteger('mediator')->nullable();
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->date('published_date')->nullable();
        });

        Schema::create('permohonan_pkwt', function (Blueprint $table) {
            $table->increments('id_pkwt');
            $table->unsignedInteger('company_id')->index();
            $table->string('pemberi_kerja', 255);
            $table->string('penerima_kerja', 255);
            $table->string('npp', 100)->unique();
            $table->string('kode_badan_usaha', 100)->unique();
            $table->string('perjanjian_kerja_file', 255)->nullable();
            $table->string('surat_permohonan', 255)->nullable();
            $table->string('final_pkwt_file', 255)->nullable();
            $table->tinyInteger('process_status')->default(0);
            $table->integer('bpjs_tk_status')->default(0);
            $table->integer('bpjs_ks_status')->default(0);
            $table->integer('mediator_status')->default(0);
            $table->unsignedTinyInteger('pembetulan_ke')->default(0);
            $table->text('decline_reason')->nullable();
            $table->unsignedInteger('mediator')->nullable();
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->date('published_date')->nullable();
        });

        Schema::create('permohonan_pkb', function (Blueprint $table) {
            $table->increments('id_pkb');
            $table->unsignedInteger('company_id')->index();
            $table->string('tahun_company', 4);
            $table->tinyInteger('status_modal_company')->nullable();
            $table->string('bidang_usaha', 255);
            $table->string('npp', 100)->unique();
            $table->string('kode_badan_usaha', 100)->index();
            $table->date('date_pkb_start')->nullable();
            $table->date('date_pkb_end')->nullable();
            $table->unsignedBigInteger('upah_min')->default(0);
            $table->unsignedBigInteger('upah_max')->default(0);
            $table->string('daerah_operasi', 255)->nullable();
            $table->string('no_anggota_apindo', 255)->nullable();
            $table->string('koperasi_pekerja', 255)->nullable();
            $table->string('file_naskah_pkb', 255)->nullable();
            $table->string('last_payment_bpjs', 255)->nullable();
            $table->string('surat_permohonan', 255)->nullable();
            $table->string('final_pkb_file', 255)->nullable();
            $table->tinyInteger('process_status')->default(0);
            $table->integer('bpjs_tk_status')->default(0);
            $table->integer('bpjs_ks_status')->default(0);
            $table->unsignedTinyInteger('pendaftaran_ke')->default(0);
            $table->text('decline_reason')->nullable();
            $table->unsignedInteger('mediator')->nullable();
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->date('published_date')->nullable();
            $table->integer('mediator_status')->default(0);
        });

        Schema::create('report_tkdn', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nik', 16);
            $table->string('jenis_kelamin', 30)->nullable();
            $table->string('last_education', 20)->nullable();
            $table->string('jurusan', 50)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->tinyInteger('is_disabilitas')->nullable()->default(0);
            $table->string('jabatan', 255);
            $table->string('company_name', 255);
            $table->text('company_address')->nullable();
            $table->tinyInteger('is_processed')->default(0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('id_jobvacancy')->nullable();
            $table->string('year', 4)->default('2023');
        });

        Schema::create('tka', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_cpmi', 255);
            $table->string('nik', 255)->nullable();
            $table->string('jenis_kelamin', 30)->nullable();
            $table->string('last_education', 50)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->string('ttl', 255)->default('');
            $table->string('address', 255)->default('');
            $table->string('status', 255)->default('');
            $table->string('company', 255)->default('');
            $table->string('country_of_destination', 255)->default('');
            $table->string('destination', 255)->default('');
            $table->string('no_telp', 255)->nullable();
            $table->string('year', 4)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        foreach ([
            'tka', 'report_tkdn', 'permohonan_pkb', 'permohonan_pkwt', 'permohonan_pp',
            'serikat', 'wlkp', 'karyawan', 'client_notification', 'notification',
            'faq', 'dispute_log', 'dispute',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
