<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->unsignedBigInteger('master_charts_id');
            $table->string('desc');
            $table->integer('debit')->nullable();
            $table->integer('credit')->nullable();
            $table->timestamps();

            $table->foreign('master_charts_id')->references('id')->on('master_charts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
