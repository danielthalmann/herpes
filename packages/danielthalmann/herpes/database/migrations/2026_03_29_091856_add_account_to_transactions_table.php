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
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('account_id', 'account_from_id');
            $table->uuid('account_to_id')->nullable();
            $table->removeColumn('account_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('account_from_id', 'account_id');
            $table->removeColumn('account_to_id');
            $table->string('account_text', 1024)->nullable();
        });
    }
};
