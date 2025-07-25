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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->date('as_of')->nullable();
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->decimal('expected_balance', 10, 2)->default(0);
            $table->decimal('actual_balance', 10, 2)->default(0);
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
