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
        Schema::create('purchase_product_batches', function (Blueprint $table) {
           $table->id();
                $table->integer('purchase_id');
                $table->string('product_type')->nullable();
                $table->string('batch_no')->nullable();
                $table->string('expire_at')->nullable();
                $table->integer('product_id');
                $table->integer('quantity');
                 $table->integer('rem_quantity');
                $table->string('tax', '50')->nullable();
                $table->float('discount')->default('0.00');
                $table->float('price')->default('0.00');
                $table->text('description')->nullable();
                $table->integer('workspace')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_product_batches');
    }
};
