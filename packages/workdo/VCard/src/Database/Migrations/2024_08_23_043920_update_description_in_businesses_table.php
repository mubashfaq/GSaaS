<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('businesses')) {
            Schema::table('businesses', function (Blueprint $table) {
                if (Schema::hasColumns('businesses', ['description', 'meta_description'])) {
                    $table->longText('description')->nullable()->change();
                    $table->longText('meta_description')->nullable()->change();
                }
            });
        }
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
        });
    }
};
