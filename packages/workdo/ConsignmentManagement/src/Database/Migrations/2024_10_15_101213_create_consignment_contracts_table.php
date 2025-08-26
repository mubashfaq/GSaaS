<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('consignment_contracts')) {
            Schema::create('consignment_contracts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('party_a');
                $table->unsignedBigInteger('party_b');
                $table->enum('contract_type', ['Supply' , 'Purchase'])->nullable();
                $table->date('start_date');
                $table->date('end_date');
                $table->longText('terms_and_conditions')->nullable();
                $table->integer('workspace')->nullable();
                $table->integer('created_by')->default(0);
                $table->foreign('party_a')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('party_b')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_contracts');
    }
};
