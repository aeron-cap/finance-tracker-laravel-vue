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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('status_id')->default(0);
            $table->string('status_name');
            $table->string('budget_name');
            $table->float('amount_to_budget', 4);
            $table->integer('cutoff_type')->nullable();
            $table->date('budget_date');
            // id integer [primary key]
            // user_id integer [not null]
            // status_id integer
            // status_name string
            // budget_name string
            // amount_to_budget decimal(10,2)
            // cutoff_type integer
            // budget_date date
            // created_at timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
