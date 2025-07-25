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
        //
        DB::table('budget_types')->insert([
            // Expense types
            ['name' => 'Budget', 'description' => 'Budget', 'type' => 'Expense'],
            ['name' => 'Clothes', 'description' => 'Clothes', 'type' => 'Expense'],
            ['name' => 'Debt', 'description' => 'Debt', 'type' => 'Expense'],
            ['name' => 'Electricity', 'description' => 'Electricity', 'type' => 'Expense'],
            ['name' => 'Emergency Fund', 'description' => 'Emergency Fund', 'type' => 'Expense'],
            ['name' => 'Food', 'description' => 'Food', 'type' => 'Expense'],
            ['name' => 'Goal', 'description' => 'Goal', 'type' => 'Expense'], // 👈
            ['name' => 'Grocery', 'description' => 'Grocery', 'type' => 'Expense'],
            ['name' => 'Healthcare', 'description' => 'Healthcare', 'type' => 'Expense'],
            ['name' => 'Internet', 'description' => 'Internet', 'type' => 'Expense'],
            ['name' => 'Leisure', 'description' => 'Leisure', 'type' => 'Expense'],
            ['name' => 'Load', 'description' => 'Load', 'type' => 'Expense'],
            ['name' => 'Miscellaneous', 'description' => 'Miscellaneous', 'type' => 'Expense'],
            ['name' => 'Mobile Data', 'description' => 'Mobile Data', 'type' => 'Expense'],
            ['name' => 'MP2', 'description' => 'MP2', 'type' => 'Expense'],
            ['name' => 'Online Bank', 'description' => 'Online Bank', 'type' => 'Expense'],
            ['name' => 'Pagibig', 'description' => 'Pagibig', 'type' => 'Expense'],
            ['name' => 'Philhealth', 'description' => 'Philhealth', 'type' => 'Expense'],
            ['name' => 'SSS', 'description' => 'SSS', 'type' => 'Expense'],
            ['name' => 'Subscriptions', 'description' => 'Subscriptions', 'type' => 'Expense'],
            ['name' => 'Total', 'description' => 'Total', 'type' => 'Expense'],
            ['name' => 'Transportation', 'description' => 'Transportation', 'type' => 'Expense'],
            ['name' => 'Gift', 'description' => 'Gift', 'type' => 'Expense'],
            
            // Income types
            ['name' => 'Reimbursement', 'description' => 'Reimbursement', 'type' => 'Income'],
            ['name' => 'Salary', 'description' => 'Salary', 'type' => 'Income'],
            ['name' => 'Savings', 'description' => 'Savings', 'type' => 'Income'],
            ['name' => 'Total', 'description' => 'Total', 'type' => 'Income'],
            ['name' => 'Goal', 'description' => 'Goal', 'type' => 'Income'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
