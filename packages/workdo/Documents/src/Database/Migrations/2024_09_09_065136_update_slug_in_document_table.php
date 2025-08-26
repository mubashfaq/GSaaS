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
        if (Schema::hasTable('document')) {
            Schema::table('document', function (Blueprint $table) {
                if (!Schema::hasColumn('document','slug')) {
                    $table->string('slug')->default('document')->after('additional_description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document', function (Blueprint $table) {
            //
        });
    }
};
