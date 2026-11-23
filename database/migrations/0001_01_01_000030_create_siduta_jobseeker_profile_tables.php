<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position', 100)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('time', 32)->nullable();
            $table->string('company', 250)->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('lpk_id')->nullable();
            $table->integer('user_id')->index();
            $table->dateTime('updated')->nullable();
            $table->timestamp('created')->useCurrent();
        });

        Schema::create('user_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('file_url', 255);
            $table->string('title', 255)->nullable();
            $table->tinyInteger('type')->default(1);
            $table->timestamp('created')->useCurrent();
            $table->dateTime('updated')->nullable();
            $table->tinyInteger('deleted')->default(0);
        });

        Schema::create('user_language', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->index();
            $table->string('language', 256);
            $table->timestamp('created')->useCurrent();
            $table->integer('deleted')->default(0);
        });

        Schema::create('user_listskill', function (Blueprint $table) {
            $table->increments('id_listskill');
            $table->integer('user_id')->index();
            $table->integer('skill_id')->index();
        });

        Schema::create('user_list_disability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('user_disability')->index();
            $table->timestamp('created')->useCurrent();
        });

        Schema::create('user_desired_job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->index();
            $table->integer('id_ak1')->index();
            $table->string('position', 256);
            $table->string('sallary', 256)->default('0');
            $table->string('placement', 256)->default('Dalam Kota');
            $table->string('location', 256)->default('1');
            $table->timestamp('created')->useCurrent();
            $table->integer('deleted')->default(0);
            $table->string('nation', 15)->nullable();
        });

        Schema::create('user_trained', function (Blueprint $table) {
            $table->increments('id_trained');
            $table->integer('user_id')->index();
            $table->integer('training_id')->index();
            $table->integer('is_graduated')->default(0);
            $table->timestamp('created')->useCurrent();
        });

        Schema::create('user_undefined', function (Blueprint $table) {
            $table->increments('id_unuser');
            $table->string('first_name_unuser', 255);
            $table->string('last_name_unuser', 255);
            $table->string('address_unuser', 255);
            $table->date('dob_unuser');
            $table->integer('city_id')->index();
            $table->integer('lc_id')->index();
            $table->timestamp('created_unuser')->useCurrent();
            $table->integer('deleted_unuser')->default(0);
        });

        Schema::create('ak1', function (Blueprint $table) {
            $table->increments('id_ak1');
            $table->integer('user_id')->index();
            $table->integer('process_status')->default(1);
            $table->integer('approved_by')->nullable();
            $table->string('decline_reason', 255)->nullable();
            $table->timestamp('created_ak1')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->integer('deleted_ak1')->default(0);
        });
    }

    public function down(): void
    {
        foreach ([
            'ak1', 'user_undefined', 'user_trained', 'user_desired_job',
            'user_list_disability', 'user_listskill', 'user_language',
            'user_files', 'user_experience',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
