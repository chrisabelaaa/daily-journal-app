<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all activities with status 'Completed' to 'Done'
        DB::table('activities')
            ->where('status', 'Completed')
            ->update(['status' => 'Done']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to 'Completed' if needed
        DB::table('activities')
            ->where('status', 'Done')
            ->update(['status' => 'Completed']);
    }
};
