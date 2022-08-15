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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ekameti_id')->constrained()->cascadeOnDelete();
            $table->integer('total_amount')->default()->length(20);
            $table->integer('no_of_installment')->default()->length(20);
            $table->integer('remaining_installment')->default()->length(20);
            $table->string('transaction_resource')->default()->length(20);
            $table->string('transaction_type')->nullable()->length(20);
            $table->date('transaction_date')->nullable();
            $table->date('last_update')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
