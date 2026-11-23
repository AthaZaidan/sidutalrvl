<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id_prov');
            $table->string('prov_name', 255)->nullable();
            $table->integer('locationid')->nullable();
            $table->integer('status')->default(1);
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id_city');
            $table->string('city_name', 255)->nullable();
            $table->integer('prov_id')->nullable();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('continent', 30)->nullable();
            $table->integer('phone')->default(0);
        });

        Schema::create('badan_usaha', function (Blueprint $table) {
            $table->increments('id_badanusaha');
            $table->string('name_badanusaha', 256);
            $table->timestamp('created_badanusaha')->useCurrent();
            $table->string('deleted_badanusaha', 1)->default('0');
        });

        Schema::create('category', function (Blueprint $table) {
            $table->increments('id_category');
            $table->string('name_category', 256);
            $table->timestamp('created_category')->useCurrent();
            $table->string('deleted_category', 1)->default('0');
        });

        Schema::create('company_status_modal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->dateTime('created_at')->useCurrent();
            $table->tinyInteger('is_deleted')->default(0);
        });

        Schema::create('disability', function (Blueprint $table) {
            $table->increments('id_disability');
            $table->string('name_disability', 128);
            $table->timestamp('created_disability')->useCurrent();
            $table->string('deleted_disability', 1)->default('0');
        });

        Schema::create('education_level', function (Blueprint $table) {
            $table->increments('id_educationlevel');
            $table->string('name_educationlevel', 64);
            $table->timestamp('created_educationlevel')->useCurrent();
            $table->string('deleted_educationlevel', 1)->default('0');
        });

        Schema::create('job_field', function (Blueprint $table) {
            $table->increments('id_jobfield');
            $table->string('name_jobfield', 128);
            $table->timestamp('created_jobfield')->useCurrent();
            $table->string('deleted_jobfield', 1)->default('0');
        });

        Schema::create('sub_job_field', function (Blueprint $table) {
            $table->increments('id_subjobfield');
            $table->string('name_subjobfield', 128);
            $table->integer('id_job_field')->index();
            $table->timestamp('created_subjobfield')->useCurrent();
            $table->string('deleted_subjobfield', 1)->default('0');
        });

        Schema::create('major', function (Blueprint $table) {
            $table->increments('id_major');
            $table->string('name_major', 128);
            $table->timestamp('created_major')->useCurrent();
            $table->string('deleted_major', 1)->default('0');
        });

        Schema::create('school', function (Blueprint $table) {
            $table->increments('id_school');
            $table->string('name_school', 128);
            $table->integer('education_level_id')->index();
            $table->timestamp('created_school')->useCurrent();
            $table->string('deleted_school', 1)->default('0');
        });

        Schema::create('university', function (Blueprint $table) {
            $table->increments('id_university');
            $table->string('name_university', 444);
            $table->timestamp('created_university')->useCurrent();
            $table->string('deleted_university', 1)->default('0');
            $table->string('Diploma', 1)->default('1');
            $table->string('S1', 1)->default('1');
            $table->string('S2', 1)->default('1');
            $table->string('S3', 1)->default('1');
        });

        Schema::create('sector_potential', function (Blueprint $table) {
            $table->increments('id_sector');
            $table->string('name_sector', 128);
            $table->timestamp('created_sector')->useCurrent();
            $table->string('deleted_sector', 1)->default('0');
        });

        Schema::create('skill', function (Blueprint $table) {
            $table->increments('id_skill');
            $table->string('name_skill', 100);
            $table->timestamp('created_skill')->useCurrent();
            $table->string('deleted_skill', 1)->default('0');
        });

        Schema::create('vocational', function (Blueprint $table) {
            $table->increments('id_vocational');
            $table->string('name_vocational', 128);
            $table->timestamp('created_vocational')->useCurrent();
            $table->string('deleted_vocational', 1)->default('0');
        });

        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->tinyInteger('deleted_jabatan')->default(0);
            $table->integer('created_by')->default(1);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('list_dispute_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 256);
            $table->timestamp('created')->useCurrent();
            $table->integer('deleted')->default(0);
        });

        Schema::create('faq_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 256);
            $table->timestamp('created')->useCurrent();
            $table->tinyInteger('deleted')->default(0);
        });
    }

    public function down(): void
    {
        foreach ([
            'faq_category', 'list_dispute_category', 'jabatan', 'vocational', 'skill',
            'sector_potential', 'university', 'school', 'major', 'sub_job_field',
            'job_field', 'education_level', 'disability', 'company_status_modal',
            'category', 'badan_usaha', 'countries', 'cities', 'provinces',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
