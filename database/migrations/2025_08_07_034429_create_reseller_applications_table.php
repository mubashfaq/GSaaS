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
        Schema::create('reseller_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name');
            $table->string('company_website')->nullable();
            $table->enum('company_size', ['1-10', '11-50', '51-200', '201-500', '500+']);
            $table->string('industry');
            $table->enum('experience_level', ['Beginner', 'Intermediate', 'Advanced', 'Expert']);
            $table->text('why_reseller');
            $table->text('target_market')->nullable();
            $table->decimal('expected_monthly_sales', 10, 2)->nullable();
            $table->boolean('has_sales_team')->default(false);
            $table->integer('team_size')->nullable();
            $table->text('additional_info')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'under_review'])->default('pending');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->text('review_notes')->nullable();
            $table->timestamps();

            $table->index(['email', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_applications');
    }
};
