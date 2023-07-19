<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('late_interval')->nullable();
            $table->string('firebase_apiKey')->nullable();
            $table->string('firebase_authDomain')->nullable();
            $table->string('firebase_projectId')->nullable();
            $table->string('firebase_storageBucket')->nullable();
            $table->string('firebase_messagingSenderId')->nullable();
            $table->string('firebase_appId')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('pwd_reset_expire')->default(15);
            $table->string('mail_from_name')->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_encryption')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}