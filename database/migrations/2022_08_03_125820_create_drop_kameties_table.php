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
        Schema::create('drop_kameties', function (Blueprint $table) {
            $table->id();
            $table->integer('ekameti_id');
            $table->integer('user_id');
            $table->integer('kameti_number')->nullable();
            $table->date('drop_date');
            $table->date('status');
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
        Schema::dropIfExists('drop_kameties');
    }
};
