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
            DB::statement('ALTER TABLE `posts` CHANGE `ahrep_traffic` `ahref_traffic` INT(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE `posts` CHANGE `ahref_traffic` `ahrep_traffic` INT(255)');
        });
    }
};
