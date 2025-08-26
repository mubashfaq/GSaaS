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
        if (!Schema::hasTable('consignment_returns')) {
            Schema::create('consignment_returns', function (Blueprint $table) {
                $table->id();
                $table->integer('sale_order_id');
                $table->integer('product_id');
                $table->integer('consignment_id');
                $table->integer('quantity');
                $table->longText('return_reason');
                $table->date('return_date');
                $table->string('status')->default('Pending');
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
        Schema::dropIfExists('consignment_returns');
    }
};
