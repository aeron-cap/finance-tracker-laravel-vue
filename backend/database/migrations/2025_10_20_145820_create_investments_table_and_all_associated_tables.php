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
        Schema::create('investments', function (Blueprint $table) {
          $table->id();
          $table->timestamps();
          $table->softDeletes();
          $table->integer('budget_id')->default(0);
          $table->string('budget_name')->nullable();
          $table->string('name');
          $table->decimal('amount', 10, 2)->default(0);
          $table->integer('budget_type_id')->default(0);
          $table->string('budget_type_name')->nullable();
          $table->integer('account_id')->default(0);
          $table->string('account_name')->nullable(0);
          $table->integer('status_id')->default(0);
          $table->integer('status_name')->nullable();
          $table->boolean('show_in_dashboard')->default(0);
          $table->decimal('running_balance', 10, 2)->default(0);
          $table->integer('investment_type_id')->default(0);
          $table->string('investment_type_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
