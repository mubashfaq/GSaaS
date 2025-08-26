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
        if (!Schema::hasTable('consignment_compliances')) {
            Schema::create('consignment_compliances', function (Blueprint $table) {
                $table->id();
                $table->string('related_entity');
                $table->string('compliance_type');
                $table->enum('status', ['Compliant' , 'Non-Compliant'])->nullable();
                $table->date('report_date');
                $table->longText('remarks')->nullable();
                $table->integer('workspace')->nullable();
                $table->integer('created_by')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignment_compliances');
    }
};
