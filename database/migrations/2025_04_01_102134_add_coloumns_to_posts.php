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
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('no_gp')->nullable()->after('country');
            $table->integer('no_li')->nullable()->after('no_gp');
            $table->integer('o_gp')->nullable()->after('no_li');
            $table->integer('o_li')->nullable()->after('o_gp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('no_gp');
            $table->dropColumn('no_li');
            $table->dropColumn('o_gp');
            $table->dropColumn('o_li');
        });
    }
};
