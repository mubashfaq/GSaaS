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
        if (!Schema::hasTable('quickbook_items')) {
            Schema::create('quickbook_items', function (Blueprint $table) {
                $table->id();
                $table->integer('item_id')->default(0);
                $table->integer('quickbook_item_id')->default(0);
                $table->integer('workspace')->nullable();
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
        Schema::dropIfExists('quickbook_items');
    }
};
