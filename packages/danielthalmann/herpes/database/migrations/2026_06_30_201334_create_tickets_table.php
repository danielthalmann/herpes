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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->uuid('customer_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->integer('reporter_id')->nullable();
            $table->integer('assignee_id')->nullable();
            $table->integer('times')->nullable();
            $table->string('eval_times')->nullable();
            $table->boolean('invoice')->default(0)->nullable();
            $table->dateTime('invoiced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
