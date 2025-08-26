<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('purchase_orders')) {

            Schema::create('purchase_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('consignment_id')->constrained(table: 'consignments')->onUpdate('NO ACTION')->onDelete('cascade');
                $table->integer('vendor_id');
                $table->date('date');
                $table->string('subtotal');
                $table->string('commission');
                $table->string('totalamount');
                $table->integer('workspace_id')->nullable();
                $table->integer('created_by')->default('0');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
