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
        if (!Schema::hasTable('consignment_products')) {
            Schema::create('consignment_products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description');
                $table->string('weight');
                $table->string('unit_price');
                $table->integer('quantity');
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
        Schema::dropIfExists('consignment_products');
    }
};
