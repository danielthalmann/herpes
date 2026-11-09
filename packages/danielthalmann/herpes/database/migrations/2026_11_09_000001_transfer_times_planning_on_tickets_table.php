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
        DB::table('tickets')->select('id', 'eval_times')->get()->each(function ($ticket) {
            DB::table('tickets')->where('id', $ticket->id)->update(['times_planning' => floatval($ticket->eval_times)]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
