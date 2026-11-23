<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jumlahkaryawan_lpk', function (Blueprint $table) {
            $table->increments('id_jumlahkaryawan');
            $table->integer('lpk_id')->nullable()->index();
            $table->integer('tpt_lk')->nullable()->default(0);
            $table->integer('tpt_p')->nullable()->default(0);
            $table->string('ket_tpt', 255)->nullable();
            $table->integer('tptp_lk')->nullable()->default(0);
            $table->integer('tptp_p')->nullable()->default(0);
            $table->string('ket_tptp', 255)->nullable();
            $table->integer('it_lk')->nullable()->default(0);
            $table->integer('it_p')->nullable()->default(0);
            $table->string('ket_it', 255)->nullable();
            $table->integer('itp_lk')->nullable()->default(0);
            $table->integer('itp_p')->nullable()->default(0);
            $table->string('ket_itp', 255)->nullable();
            $table->integer('itbn_lk')->nullable()->default(0);
            $table->integer('itbin_lk')->nullable()->default(0);
            $table->integer('ak_lk')->nullable()->default(0);
            $table->integer('ak_p')->nullable()->default(0);
            $table->string('ket_ak', 255)->nullable();
            $table->integer('aba_lk')->nullable()->default(0);
            $table->integer('aba_p')->nullable()->default(0);
            $table->string('ket_aba', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kegiatan_p2_lpk', function (Blueprint $table) {
            $table->increments('id_kp2_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('nama_pelatihan', 255)->nullable();
            $table->date('jadwal_pelatihan')->nullable();
            $table->integer('jumlah_pesertalat')->nullable()->default(0);
            $table->integer('jumlah_lulusanlat')->nullable()->default(0);
            $table->tinyInteger('jenis_sertifikat')->nullable()->default(1);
            $table->integer('jumlah_lulusanker')->default(0);
            $table->integer('jumlah_lulusanwir')->default(0);
            $table->string('ket_kegiatanp2', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kegiatan_p2tuk_lpk', function (Blueprint $table) {
            $table->increments('id_kp2tuk_lpk');
            $table->integer('lpk_id')->index();
            $table->string('kejuruan_tuk', 255);
            $table->string('sertifikasi_tuk', 255);
            $table->integer('kapasitas_tuk')->default(0);
            $table->string('lsp_tuk', 255);
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kegiatan_p3_lpk', function (Blueprint $table) {
            $table->increments('id_kp3_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('nama_program', 255)->nullable();
            $table->string('inisiator_pemohon', 255)->nullable();
            $table->integer('durasi_pelatihan')->nullable()->default(0);
            $table->string('standar_kompetensi', 255)->nullable();
            $table->string('ket_kegiatanp3', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kegiatan_pksdm_lpk', function (Blueprint $table) {
            $table->increments('id_pksdm_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('nama_kegiatan', 255)->nullable();
            $table->date('jadwal')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->string('penyelenggara', 255)->nullable();
            $table->string('ket_kegiatan_pksdm', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kegiatan_puk_lpk', function (Blueprint $table) {
            $table->increments('id_kpuk_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('nama_lps', 255)->nullable();
            $table->string('skema_sertifikasi', 255)->nullable();
            $table->date('jadwal_pelaksanaan')->nullable();
            $table->integer('jumlah_pesertauji')->nullable()->default(0);
            $table->integer('jumlah_kompeten')->nullable()->default(0);
            $table->string('ket_kegiatanpuk', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kemitraan_lpk', function (Blueprint $table) {
            $table->increments('id_kemitraan_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('nama_mitra', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('bentuk_kemitraan', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('kendala_lpk', function (Blueprint $table) {
            $table->increments('id_kendala_lpk');
            $table->integer('lpk_id')->nullable()->index();
            $table->string('kendala', 255)->nullable();
            $table->string('solusi', 255)->nullable();
            $table->string('ket_kendala', 255)->nullable();
            $table->integer('sms')->default(1);
            $table->integer('yr1')->default(2025);
            $table->integer('yr2')->default(2026);
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_locked')->default(0);
        });

        Schema::create('survey', function (Blueprint $table) {
            $table->increments('id_respondent');
            $table->string('name', 100);
            $table->integer('age');
            $table->string('gender', 20);
            $table->integer('education');
            $table->integer('job');
            $table->string('no_hp', 20);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('survey_response', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('respondent_id')->index();
            for ($i = 1; $i <= 13; $i++) {
                $table->unsignedTinyInteger("question_{$i}")->default(4);
            }
        });

        Schema::create('survey_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable()->default(1);
            $table->integer('updated_by')->nullable();
        });

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('questioner');
            $table->string('label_name_1', 255);
            $table->string('label_name_2', 255);
            $table->string('label_name_3', 255);
            $table->string('label_name_4', 255);
            $table->integer('label_value_1')->nullable()->default(1);
            $table->integer('label_value_2')->nullable()->default(2);
            $table->integer('label_value_3')->nullable()->default(3);
            $table->integer('label_value_4')->nullable()->default(4);
            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable()->default(1);
            $table->integer('updated_by')->nullable();
        });

        Schema::create('survey_responden_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('education', 100)->nullable();
            $table->string('job', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('saran')->nullable();
            $table->integer('survey_service_id')->nullable()->index();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->string('email', 100)->nullable();
            $table->string('address', 100)->nullable();
            $table->integer('district_id')->nullable();
        });

        Schema::create('survey_responden_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responden_id')->index();
            $table->integer('question_id')->index();
            $table->integer('persepsi_value');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        foreach ([
            'survey_responden_answers', 'survey_responden_profiles', 'survey_questions',
            'survey_services', 'survey_response', 'survey',
            'kendala_lpk', 'kemitraan_lpk', 'kegiatan_puk_lpk', 'kegiatan_pksdm_lpk',
            'kegiatan_p3_lpk', 'kegiatan_p2tuk_lpk', 'kegiatan_p2_lpk', 'jumlahkaryawan_lpk',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
