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
            $table->uuid('id')->primary();
            $table->datetime('date')->nullable();
            $table->integer('transaction_group')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_name', 50)->nullable();
            $table->uuid('account_id')->nullable();
            $table->string('account_text', 1024)->nullable();
            $table->uuid('invoice_id')->nullable();
            $table->string('accounting_text', 1024)->nullable(); // texte comptable
            $table->string('tax_code')->nullable();
            $table->float('tax_rate', 10)->nullable();
            $table->float('tax_value', 10)->nullable();
            $table->float('debit', 10)->nullable();
            $table->float('credit', 10)->nullable();
            $table->timestamps();
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
