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
        if (!Schema::hasTable('restaurant_place_orders')) {
        Schema::create('restaurant_place_orders', function (Blueprint $table) {
            $table->id();
            $table->string('quantity')->nullable();
            $table->longText('description')->nullable();
            $table->integer('item_id')->default();
            $table->integer('created_by')->default('0');
            $table->integer('workspace')->default('0');
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
        Schema::dropIfExists('restaurant_place_orders');
    }
};
