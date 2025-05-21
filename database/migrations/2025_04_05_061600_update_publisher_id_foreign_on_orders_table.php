<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['publisher_id']);
    
            // Optional: Modify the column if needed
            // $table->unsignedBigInteger('publisher_id')->nullable()->change();
    
            // Re-add updated foreign key (example: onDelete cascade)
            $table->foreign('publisher_id')
                  ->references('user_id')
                  ->on('websites')
                  ->onDelete('cascade'); // or 'set null', 'restrict', etc.
        });
    }
    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['publisher_id']);
            $table->foreign('publisher_id')
                  ->references('user_id')
                  ->on('websites')
                  ->onDelete('restrict'); // Revert back to original
        });
    }
};
