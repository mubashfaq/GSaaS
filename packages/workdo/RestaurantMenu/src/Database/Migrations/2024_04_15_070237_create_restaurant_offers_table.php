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
        if (!Schema::hasTable('restaurant_offers')) {
            Schema::create('restaurant_offers', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('discount')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('items')->nullable();
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
        Schema::dropIfExists('restaurant_offers');
    }
};
