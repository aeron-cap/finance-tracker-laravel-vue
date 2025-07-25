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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('expense_date');
            $table->integer('budget_type_id');
            $table->string('budget_type_name');
            $table->integer('account_id');
            $table->string('account_name');
            $table->float('amount', 4);
            $table->string('description');
            $table->integer('status_id');
            $table->string('status_name');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
