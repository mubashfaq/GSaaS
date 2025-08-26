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
        if (!Schema::hasTable('quickbook_payments')) {
        Schema::create('quickbook_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id')->default(0);
            $table->integer('quickbook_payment_id')->default(0);
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
        Schema::dropIfExists('quickbook_payments');
    }
};
