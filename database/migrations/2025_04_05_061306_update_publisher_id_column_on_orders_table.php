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
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->unsignedBigInteger('publisher_id');
        //     $table->foreign('publisher_id')->references('user_id')->on('posts')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->dropForeign(['publisher_id']);
        //     $table->foreign('publisher_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }
};
