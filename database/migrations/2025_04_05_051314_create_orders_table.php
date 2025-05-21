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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id');
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('website_id');
            $table->foreign('advertiser_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('publisher_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->string('host_url')->nullable();
            $table->integer('da')->nullable();
            $table->string('tat')->nullable();
            $table->integer('semrush')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['new', 'in_progress', 'reject', 'complete'])->default('new');
            $table->enum('type', ['provide_content', 'expert_writer', 'link_insertion'])->nullable();
            $table->string('language')->nullable();
            $table->string('attachment')->nullable();
            $table->string('special_instruction')->nullable();
            $table->string('existing_post_url')->nullable();
            $table->string('title_suggestion')->nullable();
            $table->string('keywords')->nullable();
            $table->string('anchor_text')->nullable();
            $table->string('country')->nullable();
            $table->string('word_count')->nullable();
            $table->string('category')->nullable();
            $table->string('reference_link')->nullable();
            $table->string('target_url')->nullable();
            $table->string('special_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
