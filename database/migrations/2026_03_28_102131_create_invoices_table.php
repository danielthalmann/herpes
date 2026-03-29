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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ref')->nullable();
            $table->dateTime('invoice_date');
            $table->uuid('customer_id')->index();
            $table->string('customer_company')->nullable();
            $table->string('customer_department')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_street')->nullable();
            $table->string('customer_zipcode')->nullable();
            $table->string('customer_city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
