<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Monthly
        // Bi-Monthly
        // Custom (Number of frequency)
        DB::table('cutoff_types')->insert(
            array(
                ['name' => 'Monthly', 'description' => 'Monthly'],
                ['name' => 'Bi-Monthly', 'description' => 'Bi-Monthly'],
                ['name' => 'Custom', 'description' => 'Custom'],
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
