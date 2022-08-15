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
        Schema::create('ekametis', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('total_amount_kameti');
            $table->string('ekameti_type')->nullable();
            $table->string('ekameti_Holder_full_name')->nullable();
            $table->integer('installment')->nullable();
            $table->integer('total_months')->nullable();
            $table->integer('withdraw_kameties');
            $table->integer('invitation_code')->unique();
            $table->string('allocated_kameties')->nullable();
            $table->date('starting_date');
            $table->date('ending_date');
            $table->string('status');
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
        Schema::dropIfExists('ekameti');
    }
};
