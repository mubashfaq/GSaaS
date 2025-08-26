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
        if (!Schema::hasTable('document')) {
            Schema::create('document', function (Blueprint $table) {
                $table->id();
                $table->string('subject')->nullable();
                $table->integer('user_id');
                $table->integer('project_id')->nullable();
                $table->integer('type');
                $table->string('notes')->nullable();
                $table->string('status')->default('pending');
                $table->longtext('description')->nullable();
                $table->longtext('additional_description')->nullable();
                $table->integer('document_id')->default(0);
                $table->integer('template_id')->default(0);
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
        Schema::dropIfExists('document');
    }
};
