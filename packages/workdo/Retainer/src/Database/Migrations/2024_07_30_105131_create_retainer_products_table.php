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
        if (!Schema::hasTable('retainer_products')) {
            
            Schema::create('retainer_products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('retainer_id');
                $table->string('product_type')->nullable();
                $table->integer('product_id');
                $table->integer('quantity');
                $table->string('tax')->default('0')->nullable();
                $table->float('discount')->default('0.00');
                $table->float('price')->default('0.00');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retainer_products');
    }
};
