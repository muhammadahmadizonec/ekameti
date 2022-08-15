<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->bigInteger('user_cnic')->length(15)->nullable();
            $table->string('password')->default();
            $table->string('Email')->default();
            $table->string('Mobile')->nullable();
            $table->string('user_address')->nullable();
            $table->string('upload_frontside_cnic');
            $table->string('upload_backside_cnic');
            $table->date('cnic_expiry')->nullable();
            $table->integer('MOTP')->nullable();
            $table->integer('EOTP')->nullable();
            $table->integer('emailConfirm')->default(0);
            $table->string('status')->default();
            $table->integer('mobileConfirm')->default(0);
            $table->integer('verify_status')->nullable();
            $table->string('g_id')->nullable();
            $table->string('f_id')->nullable();
            $table->date('DOB')->nullable();
            $table->string('gender');
            $table->string('api_token')->default();
            $table->string('device_token')->nullable();
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
        Schema::dropIfExists('users');
    }
};
