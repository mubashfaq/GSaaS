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
        if (!Schema::hasTable('restaurant_categories')) {
            Schema::create('restaurant_categories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('category_id')->constrained(table: 'categories')->onUpdate('cascade')->onDelete('cascade');
                $table->string('name')->nullable();
                $table->string('type')->default(0);
                $table->string('color')->default('#fc544b');
                $table->string('food_image')->nullable();
                $table->integer('created_by')->default('0');
                $table->integer('workspace_id')->default('0');
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
        Schema::dropIfExists('restaurant_categories');
    }
};
