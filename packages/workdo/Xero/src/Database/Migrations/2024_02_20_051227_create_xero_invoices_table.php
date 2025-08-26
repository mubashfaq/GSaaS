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
        if (!Schema::hasTable('xero_invoices'))
        {
            Schema::create('xero_invoices', function (Blueprint $table) {
                $table->id();
                $table->integer('invoice_id')->default(0);
                $table->string('xero_invoice_id',255)->nullable();
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
        Schema::dropIfExists('xero_invoices');
    }
};
