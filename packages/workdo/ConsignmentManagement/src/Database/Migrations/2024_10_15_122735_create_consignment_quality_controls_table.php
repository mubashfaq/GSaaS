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
        if (!Schema::hasTable('consignment_quality_controls')) {
            Schema::create('consignment_quality_controls', function (Blueprint $table) {
                $table->id();
                $table->integer('consignment_id');
                $table->string('product_id');
                $table->date('check_date');
                $table->string('status')->default('Pending');
                $table->string('inspector')->default('Pending');
                $table->string('remarks')->default('Pending');
                $table->integer('workspace')->nullable();
                $table->integer('created_by')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_quality_controls');
    }
};
