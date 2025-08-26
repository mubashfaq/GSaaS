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
        if (Schema::hasTable('restaurant_place_orders')) {

            Schema::table('restaurant_place_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('restaurant_place_orders', 'varient')) {
                    $table->string('varient')->nullable()->after('quantity');
                }
                if (!Schema::hasColumn('restaurant_place_orders', 'total_price')) {
                    $table->string('total_price')->nullable()->after('varient');
                }
            });
        }
    }
};
