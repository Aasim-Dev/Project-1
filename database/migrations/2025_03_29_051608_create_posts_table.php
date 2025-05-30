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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('website_url');
            $table->string('host_url');
            $table->longtext('guidelines');
            $table->integer('da');
            $table->string('sample_post');
            $table->integer('ahref_traffic')->nullable();
            $table->integer('semrush')->nullable();
            $table->string('tat')->nullable();
            $table->boolean('status')->default(0);
            $table->string('website_name')->nullable();
            $table->string('country')->nullable();
            $table->string('normal_category')->nullable();
            $table->string('forbidden_category')->nullable();
            $table->decimal('guest_post_price', 10, 2 )->nullable();
            $table->decimal('linkinsertion_price', 10, 2 )->nullable();
            $table->decimal('fc_guest_post_price', 10, 2)->nullable();
            $table->decimal('fc_linkinsertion_price', 10, 2)->nullable();
            $table->integer('dr')->nullable();
            $table->integer('authority_score')->nullable();
            $table->integer('spam_score')->nullable();
            $table->string('backlink_type')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->string('client_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
