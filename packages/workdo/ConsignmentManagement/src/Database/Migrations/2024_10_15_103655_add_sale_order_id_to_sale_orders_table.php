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
        if (!Schema::hasColumn('sale_orders', 'sale_order_id')) {
            Schema::table('sale_orders', function (Blueprint $table) {
                $table->integer('sale_order_id')->default(0)->after('id');
            });
        }

        $saleOrders = DB::table('sale_orders')
        ->orderBy('workspace_id')
        ->get();

        $previousWorkspace = null;
        $saleId = 1;

        foreach ($saleOrders as $sale) {
            if ($sale->workspace_id != $previousWorkspace) {
                $saleId = 1;
            }

            // Update the sale_order_id for the current row
            DB::table('sale_orders')
                ->where('id', $sale->id)
                ->update(['sale_order_id' => $saleId]);

            $saleId++;
            $previousWorkspace = $sale->workspace_id;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            //
        });
    }
};
