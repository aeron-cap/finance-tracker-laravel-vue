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
        Schema::table('expenses', function (Blueprint $table) {
            //
            $table->integer('budget_id')->nullable();
            $table->string('budget_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('expenses', function (Blueprint $table) {
            //
            $table->dropColumn('budget_id');
            $table->dropColumn('budget_name');
        });
    }
};
