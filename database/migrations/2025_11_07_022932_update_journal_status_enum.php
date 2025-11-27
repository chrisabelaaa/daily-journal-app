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
        // First update any existing 'overdue' status to 'done'
        \DB::table('journals')->where('status', 'overdue')->update(['status' => 'done']);
        
        // Modify the enum column
        \DB::statement("ALTER TABLE journals MODIFY COLUMN status ENUM('pending', 'in_progress', 'done') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        \DB::statement("ALTER TABLE journals MODIFY COLUMN status ENUM('pending', 'in_progress', 'overdue') DEFAULT 'pending'");
        
        // Update 'done' back to 'overdue' 
        \DB::table('journals')->where('status', 'done')->update(['status' => 'overdue']);
    }
};
