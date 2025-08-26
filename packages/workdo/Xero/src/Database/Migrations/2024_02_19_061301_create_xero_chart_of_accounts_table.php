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
        if (!Schema::hasTable('xero_chart_of_accounts'))
        {
            Schema::create('xero_chart_of_accounts', function (Blueprint $table) {
                $table->id();
                $table->integer('chartofaccount_id')->default(0);
                $table->integer('xero_id')->default(0);
                $table->string('xero_code',250)->default(0);
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
        Schema::dropIfExists('xero_chart_of_accounts');
    }
};
