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
        Schema::create('budget_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('budget_id');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->integer('budget_type_id');
            $table->string('budget_type_name');
            $table->string('description');
            $table->float('amount', 4);
            $table->boolean('is_used')->default(0);
        });

        // Table budget_details {
        //     id integer [primary key]
        //     budget_id integer
        //     budget_type_id integer
        //     budget_type_name string
        //     description string
        //     amount decimal(10,2)
        //     is_used bool
        //     created_at timestamp
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_details');
    }
};
