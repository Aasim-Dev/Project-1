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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('website_url');
            $table->string('host_url');
            $table->integer('da');
            $table->string('sample_post');
            $table->integer('ahref_traffic')->nullable();
            $table->string('tat')->nullable();
            $table->string('country');
            $table->string('normal')->nullable();
            $table->string('other')->nullable();
            $table->decimal('guest_post_price', 10, 2 );
            $table->decimal('linkinsertion_price', 10, 2 );
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
