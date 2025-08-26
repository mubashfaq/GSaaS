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
        if(!Schema::hasTable('retainers'))
        {
            Schema::create('retainers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('retainer_id');
                $table->unsignedBigInteger('user_id')->default('0');
                $table->unsignedBigInteger('customer_id')->default('0');
                $table->string('account_type');
                $table->date('issue_date');
                $table->date('due_date')->nullable();
                $table->date('send_date')->nullable();
                $table->integer('category_id');
                $table->integer('status')->default('0');
                $table->integer('discount_apply')->default('0');
                $table->integer('converted_invoice_id')->default('0');
                $table->integer('is_convert')->default('0');
                $table->string('retainer_module')->nullable();
                $table->string('retainer_template')->nullable();
                $table->integer('workspace')->nullable();
                $table->integer('created_by')->default('0');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retainers');
    }
};
