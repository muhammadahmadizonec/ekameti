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
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->default()->length(25);
            $table->string('name')->default();
            $table->string('password')->default()->length(25);
            $table->integer('user_cnic')->length(15);
            $table->string('Email')->nullable()->length(100);
            $table->string('permission')->default();
            $table->string('status')->default();
            $table->date('submit_date')->default();
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
        Schema::dropIfExists('admin');
    }
};
