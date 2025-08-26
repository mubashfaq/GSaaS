<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('businesses', 'is_google_map_enabled')) {
            Schema::table('businesses', function (Blueprint $table) {
                $table->string('is_google_map_enabled')->nullable()->after('current_business');
                $table->text('google_map_link')->nullable()->after('is_google_map_enabled');
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
        Schema::table('', function (Blueprint $table) {

        });
    }
};
