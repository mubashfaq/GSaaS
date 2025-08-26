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
        if (!Schema::hasTable('findgooglelead_founded_lead_contacts')) {
            Schema::create('findgooglelead_founded_lead_contacts', function (Blueprint $table) {
                $table->id();
                $table->string('founded_lead_id')->nullable();
                $table->string('lead_id')->nullable();
                $table->string('is_sync')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone_no')->nullable();
                $table->string('website')->nullable();
                $table->text('address');
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
        Schema::dropIfExists('findgooglelead_founded_lead_contacts');
    }
};
