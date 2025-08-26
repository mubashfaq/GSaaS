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
        if (!Schema::hasTable('consignment_shippings')) {
            Schema::create('consignment_shippings', function (Blueprint $table) {
                $table->id();
                $table->string('consignment_id');
                $table->string('shipping_company');
                $table->string('tracking_number');
                $table->string('status')->default('Pending');
                $table->date('shipping_date');
                $table->date('estimated_delivery_date');
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
        Schema::dropIfExists('consignment_shippings');
    }
};
