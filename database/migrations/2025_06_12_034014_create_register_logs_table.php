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
        Schema::create('register_logs', function (Blueprint $table) {
            $table->id();
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->decimal('closing_balance', 10, 2)->nullable();
            $table->text('opening_note')->nullable();
            $table->text('closing_note')->nullable();
            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
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
        Schema::dropIfExists('register_logs');
    }
};
