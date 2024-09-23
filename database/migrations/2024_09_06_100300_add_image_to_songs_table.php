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
        Schema::table('songs', function (Blueprint $table) {
            Schema::table('songs', function (Blueprint $table) {
                $table->string('image_path')->nullable()->after('file_path'); 
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('songs', function (Blueprint $table) {
            Schema::table('songs', function (Blueprint $table) {
                $table->dropColumn('image_path'); 
            });
        });
    }
};
