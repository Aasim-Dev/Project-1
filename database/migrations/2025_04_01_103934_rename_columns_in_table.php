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
            DB::statement('ALTER TABLE `posts` CHANGE `no_gp` `normal_gp` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `no_li` `normal_li` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `o_gp` `other_gp` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `o_li` `other_li` INT(255)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement('ALTER TABLE `posts` CHANGE `normal_gp` `no_gp` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `normal_li` `no_li` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `other_gp` `o_gp` INT(255)');
            DB::statement('ALTER TABLE `posts` CHANGE `other_li` `o_li` INT(255)');
        });
    }
};

