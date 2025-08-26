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
        Schema::create('register_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_log_id')->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['cash_in', 'cash_out']);
            $table->text('description')->nullable();
            $table->integer('workspace')->nullable();
            $table->integer('created_by')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_transactions');
    }
};
