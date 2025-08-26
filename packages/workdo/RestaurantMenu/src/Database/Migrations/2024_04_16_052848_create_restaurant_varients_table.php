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
        if (!Schema::hasTable('restaurant_varients')) {
            Schema::create('restaurant_varients', function (Blueprint $table) {
                $table->id();
                $table->string('varient_name')->nullable();
                $table->integer('item_id')->nullable();
                $table->string('additional_price')->nullable();
                $table->string('item_attribute')->nullable();
                $table->string('status')->nullable();
                $table->integer('workspace')->default(0);
                $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('restaurant_varients');
    }
};
