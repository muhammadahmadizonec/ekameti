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
        Schema::create('kameti_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('ekameti_id')->constrained()->cascadeOnDelete();
            $table->string('status');
            $table->string('total_ekameti')->nullable();
            $table->integer('total_ekameti')->default();
            $table->integer('payable_amount')->default();
            $table->string('add_by')->nullable();
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
        Schema::dropIfExists('kameti_members');
    }
};
