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
        if (Schema::hasTable('document_comments')) {
            Schema::table('document_comments', function (Blueprint $table) {
                if (Schema::hasColumns('document_comments', ['comment'])) {
                    $table->longText('comment')->change();
                }
            });
        }
        if (Schema::hasTable('document_notes')) {
            Schema::table('document_notes', function (Blueprint $table) {
                if (Schema::hasColumns('document_notes', ['note'])) {
                    $table->longText('note')->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
