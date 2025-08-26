<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('permalink')->nullable();
            $table->text('description')->nullable();
            $table->integer('active')->default(0);
            $table->integer('discount_id')->nullable();
            $table->integer('created_by')->default('0');
            $table->integer('workspace_id')->default('0');
            
            $table->timestamps();
        });
        Schema::create('collections_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('collection_id');
            $table->text('option');
            $table->string('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('collections_meta');
    }
}
