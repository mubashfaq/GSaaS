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
        Schema::table('consignment_items', function (Blueprint $table) {
            if (!Schema::hasColumn('consignment_items', 'tax')) {
                $table->string('tax', '50')->nullable()->after('price');
            }
        });
        Schema::table('consignments', function (Blueprint $table) {
            if (!Schema::hasColumn('consignments', 'taxamount')) {
                $table->decimal('taxamount', 8,2)->default(0.00)->after('totalamount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consignment_items', function (Blueprint $table) {
            //
        });
    }
};
