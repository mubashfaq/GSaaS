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
        if (!Schema::hasTable('restaurant_orders')) {
            Schema::create('restaurant_orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_id', 100);
                $table->string('customer_id')->default(0)->nullable();
                $table->json('product')->nullable();
                $table->string('total')->nullable();
                $table->string('status')->nullable();
                $table->string('table_id')->nullable();
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
        Schema::dropIfExists('restaurant_orders');
    }
};
