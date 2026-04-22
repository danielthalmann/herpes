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
        Schema::create('balance_sheet_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('balance_sheet_id')->nullable();
            $table->string('balance_type')->nullable();
            $table->string('description')->nullable();
            $table->integer('amount')->nullable(); // value * 100
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_sheet_items');
    }
};
