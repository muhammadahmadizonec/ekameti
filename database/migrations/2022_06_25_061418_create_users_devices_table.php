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
        Schema::create('users_devices', function (Blueprint $table) {
            $table->id();
            $table->bigint('user_id')->default()->length(11);
            $table->string('dtype')->default()->length(25);
            $table->string('did')->default()->length(100);
            $table->date('dateadd')->default()->default();
            $table->date('dateremove')->nullable()->default();
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
        Schema::dropIfExists('users_devices');
    }
};
