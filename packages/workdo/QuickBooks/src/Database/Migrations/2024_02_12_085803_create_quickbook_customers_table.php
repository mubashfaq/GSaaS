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
        if (!Schema::hasTable('quickbook_customers')) {
            Schema::create('quickbook_customers', function (Blueprint $table) {
                $table->id();
                $table->integer('customer_id')->default(0);
                $table->integer('quickbook_customer_id')->default(0);
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
        Schema::dropIfExists('quickbook_customers');
    }
};
