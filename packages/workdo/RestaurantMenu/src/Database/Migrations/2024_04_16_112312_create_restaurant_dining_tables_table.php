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
        if (!Schema::hasTable('restaurant_dining_tables')) {
        Schema::create('restaurant_dining_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('size')->nullable();
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
        Schema::dropIfExists('restaurant_dining_tables');
    }
};
