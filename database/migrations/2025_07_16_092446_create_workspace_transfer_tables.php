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
       Schema::create('workspace_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->unsignedBigInteger('from_warehouse');
            $table->unsignedBigInteger('to_workspace');
            $table->unsignedBigInteger('to_warehouse');
            $table->date('date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->integer('workspace')->nullable();
            $table->integer('created_by')->default('0');
            $table->timestamps();
            
            $table->index(['from_warehouse', 'to_workspace', 'to_warehouse'], 'wt_from_to_warehouses_idx');
            $table->index('date', 'wt_date_idx');
            $table->index('status', 'wt_status_idx');
        });

        Schema::create('workspace_transfer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_transfer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->timestamps();
            
            $table->foreign('workspace_transfer_id')
                  ->references('id')
                  ->on('workspace_transfers')
                  ->onDelete('cascade');
            
            $table->index(['workspace_transfer_id', 'product_id'], 'wtp_transfer_product_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspace_transfer_products');
        Schema::dropIfExists('workspace_transfers');
    }
};
