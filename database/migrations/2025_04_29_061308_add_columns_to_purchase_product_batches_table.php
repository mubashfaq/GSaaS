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
        Schema::table('purchase_product_batches', function (Blueprint $table) {
            //
            //  $table->string('batch_no')->after('purchase_id');
            // $table->date('expire_at')->nullable()->after('batch_no');
            // $table->integer('rem_quantity')->after('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_product_batches', function (Blueprint $table) {
            //
        });
    }
};
