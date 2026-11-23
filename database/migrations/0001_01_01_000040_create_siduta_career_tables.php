<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_vacancy', function (Blueprint $table) {
            $table->increments('id_jobvacancy');
            $table->string('title_jobvacancy', 256);
            $table->integer('experience_vacancy')->default(0);
            $table->string('salary_start', 256)->nullable();
            $table->string('salary_end', 256)->nullable();
            $table->longText('desc_vacancy');
            $table->integer('jobfield_vacancy')->index();
            $table->integer('subjobfield_vacancy')->index();
            $table->integer('type_vacancy')->default(1);
            $table->integer('city_vacancy')->default(1);
            $table->integer('duration_vacancy')->default(1);
            $table->date('deadline_vacancy')->nullable();
            $table->integer('disability_status')->default(0);
            $table->integer('publish_status')->default(0);
            $table->integer('process_status')->default(0);
            $table->integer('company_id')->index();
            $table->integer('pk_id')->nullable();
            $table->longText('decline_reason')->nullable();
            $table->longText('pending_reason')->nullable();
            $table->timestamp('created_vacancy')->useCurrent();
            $table->string('deleted_vacancy', 1)->default('0');
            $table->timestamp('publish_date')->nullable();
            $table->string('nation_vacancy', 15)->nullable();
            $table->integer('education_level')->nullable();
        });

        Schema::create('jv_listskill', function (Blueprint $table) {
            $table->increments('id_jvls');
            $table->integer('jv_id')->index();
            $table->integer('skill_id')->index();
        });

        Schema::create('job_listdisability', function (Blueprint $table) {
            $table->increments('id_listdisability');
            $table->integer('job_vacancy_id')->index();
            $table->integer('disability_id')->index();
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('list_applicantjv', function (Blueprint $table) {
            $table->increments('id_listapplicant');
            $table->integer('jobvacancy_id')->index();
            $table->integer('user_id')->index();
            $table->integer('process_apply')->default(0);
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('internship', function (Blueprint $table) {
            $table->increments('id_intern');
            $table->string('title_intern', 256);
            $table->integer('experience_intern')->default(0);
            $table->string('salary_start', 256)->nullable()->default('0');
            $table->string('salary_end', 256)->nullable()->default('0');
            $table->longText('desc_intern');
            $table->longText('jobfield_intern');
            $table->integer('subjobfield_intern')->default(0);
            $table->integer('city_intern')->default(1);
            $table->integer('duration_intern')->default(1);
            $table->date('deadline_intern')->nullable();
            $table->integer('publish_status')->default(0);
            $table->integer('process_status')->default(0);
            $table->integer('company_id')->nullable()->index();
            $table->integer('lpk_id')->nullable()->index();
            $table->integer('ip_id')->default(0);
            $table->longText('decline_reason')->nullable();
            $table->longText('pending_reason')->nullable();
            $table->timestamp('created_intern')->useCurrent();
            $table->string('deleted_intern', 1)->default('0');
            $table->tinyInteger('length_intern')->default(1);
            $table->integer('min_edu_level')->default(1);
            $table->string('minage_intern', 255)->nullable()->default('18');
            $table->string('maxage_intern', 255)->nullable()->default('35');
            $table->longText('gender_intern')->nullable();
            $table->string('keterangan_in', 255)->nullable()->default('');
        });

        Schema::create('in_listskill', function (Blueprint $table) {
            $table->increments('id_inls');
            $table->integer('in_id')->index();
            $table->integer('skill_id')->index();
        });

        Schema::create('list_applicantin', function (Blueprint $table) {
            $table->increments('id_listapplicant');
            $table->integer('intern_id')->nullable()->index();
            $table->integer('user_id')->index();
            $table->integer('process_apply')->default(0);
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('training', function (Blueprint $table) {
            $table->increments('id_training');
            $table->string('title_training', 256);
            $table->longText('desc_training');
            $table->integer('city_training')->default(1);
            $table->string('price_training', 22)->nullable()->default('0');
            $table->integer('method_training')->default(1);
            $table->integer('gender_training')->default(0);
            $table->string('minage_training', 256)->default('17');
            $table->string('maxage_training', 255)->default('45');
            $table->longText('BA_training')->nullable();
            $table->longText('SR_training')->nullable();
            $table->integer('duration_training')->default(1);
            $table->date('deadline_training')->nullable();
            $table->date('date_training');
            $table->string('file_training', 128)->nullable();
            $table->string('url_documentation', 128)->nullable();
            $table->string('place_training', 128)->nullable();
            $table->integer('duration_study')->nullable();
            $table->integer('disability_status')->default(0);
            $table->integer('certificate_status')->default(1);
            $table->integer('publish_status')->default(0);
            $table->integer('process_status')->default(0);
            $table->integer('lpk_id')->index();
            $table->integer('ipo_id')->nullable();
            $table->longText('decline_reason')->nullable();
            $table->longText('pending_reason')->nullable();
            $table->timestamp('created_training')->useCurrent();
            $table->string('deleted_training', 1)->default('0');
            $table->string('keterangan_tr', 255)->nullable()->default('');
            $table->string('tujuan_tr', 255)->nullable()->default('');
        });

        Schema::create('training_listcertificate', function (Blueprint $table) {
            $table->increments('id_listcertificate');
            $table->integer('training_id')->index();
            $table->integer('certificate_id')->index();
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('training_listdisability', function (Blueprint $table) {
            $table->increments('id_listdisability');
            $table->integer('training_id')->index();
            $table->integer('disability_id')->index();
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('list_applicanttr', function (Blueprint $table) {
            $table->increments('id_listapplicant');
            $table->integer('training_id')->index();
            $table->integer('user_id')->index();
            $table->integer('process_apply')->default(0);
            $table->integer('is_graduated')->nullable();
            $table->timestamp('created_list')->useCurrent();
        });

        Schema::create('applicant_call', function (Blueprint $table) {
            $table->increments('id_call');
            $table->date('date_call');
            $table->string('hour_call', 25);
            $table->text('place_call');
            $table->text('desc_call');
            $table->integer('user_id')->index();
            $table->timestamp('created_call')->useCurrent();
        });

        Schema::create('certification', function (Blueprint $table) {
            $table->increments('id_certification');
            $table->integer('lpk_id')->index();
            $table->string('name_certification', 255);
            $table->integer('totalh_certification')->default(0);
            $table->integer('vocational_id')->default(1);
            $table->integer('totaluser_certification')->nullable();
            $table->date('date_certification');
            $table->string('loc_certification', 255);
            $table->string('absen_certification', 255)->nullable();
            $table->string('documentation_certification', 255)->nullable()->default('');
            $table->integer('process_status')->default(1);
            $table->dateTime('updated_at')->nullable();
            $table->string('decline_reason', 255)->nullable();
            $table->timestamp('created_certification')->useCurrent();
            $table->integer('deleted_certification')->default(0);
        });

        Schema::create('list_certification', function (Blueprint $table) {
            $table->increments('id_lc');
            $table->integer('certification_id')->index();
            $table->integer('user_id')->index();
            $table->string('url_file', 128)->nullable();
            $table->longText('certification_code')->nullable();
            $table->timestamp('created_lc')->useCurrent();
            $table->integer('deleted_lc')->default(0);
        });
    }

    public function down(): void
    {
        foreach ([
            'list_certification', 'certification', 'applicant_call', 'list_applicanttr',
            'training_listdisability', 'training_listcertificate', 'training',
            'list_applicantin', 'in_listskill', 'internship',
            'list_applicantjv', 'job_listdisability', 'jv_listskill', 'job_vacancy',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
