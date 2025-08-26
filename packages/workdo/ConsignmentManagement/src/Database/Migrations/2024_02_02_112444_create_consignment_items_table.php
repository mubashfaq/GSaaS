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
        if (!Schema::hasTable('consignment_items')) {

            Schema::create('consignment_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('consignment_id')->constrained(table: 'consignments')->onUpdate('NO ACTION')->onDelete('cascade');
                $table->integer('product_id');
                $table->integer('quantity');
                $table->string('price');
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
        Schema::dropIfExists('consignment_items');
    }
};
