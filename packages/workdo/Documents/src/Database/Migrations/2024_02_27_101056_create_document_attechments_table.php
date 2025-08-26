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
        if (!Schema::hasTable('document_attechments')) {
            Schema::create('document_attechments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('document_id');
                $table->string('user_id');
                $table->string('files');
                $table->integer('workspace_id')->default(0);
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
        Schema::dropIfExists('document_attechments');
    }
};
