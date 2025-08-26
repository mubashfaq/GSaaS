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
        if (!Schema::hasTable('findgooglelead_founded_leads')) {
            Schema::create('findgooglelead_founded_leads', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('keywords')->nullable();
                $table->text('address')->nullable();
                $table->string('contact')->default(0);
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
        Schema::dropIfExists('findgooglelead_founded_leads');
    }
};
