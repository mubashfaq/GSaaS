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
        if (!Schema::hasTable('consignments')) {

            Schema::create('consignments', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->integer('vendor');
                $table->string('commission');
                $table->date('date');
                $table->string('subtotal');
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
        Schema::dropIfExists('consignments');
    }
};
