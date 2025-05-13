<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // use SoftDeletes;
    // // use \OwenIt\Auditing\Auditable;

    
    // const STATUS_REJECT = 0;
    // const STATUS_NEW = 1;
    // const STATUS_ACTIVE = 2;
    // const STATUS_LATE = 5;
    // const STATUS_COMPLETED = 6;
    // const STATUS_DELIVERED = 7;
    // const STATUS_CANCEL = 8;
    // const IS_DELAY_STATUS_FALSE = 0;
    // const IS_DELAY_STATUS_TRUE = 1;
    // const IS_DELAY_STATUS_NOTHING = 2;

    // const IS_CONTINUE_DEFAULT = 0;
    // const IS_CONTINUE_REQUESTED = 1;
    // const IS_CONTINUE_ACCEPTED = 2;
    // const IS_CONTINUE_REJECTED = 3;

    // public static function statusLabels()
    // {
    //     return [
    //         self::STATUS_REJECT => 'Rejected',
    //         self::STATUS_NEW => 'New',
    //         self::STATUS_ACTIVE => 'Active',
    //         self::STATUS_LATE => 'Late',
    //         self::STATUS_COMPLETED => 'Completed',
    //         self::STATUS_DELIVERED => 'Delivered',
    //         self::STATUS_CANCEL => 'Cancelled',
    //     ];
    // }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('order_attributes', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('order_id');
        //     $table->foreign('order_id')->reference('id')->on('orders')->onDelete('cascade');
        //     $table->string('order_lable')->nullable();
        //     $table->unsignedBigInteger('website_id');
        //     $table->foreign('website_id')->reference('id')->on('posts')->onDelete('cascade');
        //     $table->text('instruction')->nullable();
        //     $table->string('content_writter')->nullable();
        //     $table->string('title')->nullable();
        //     $table->decimal('expert_price', 10, 2)->nullable();
        //     $table->unsignedBigInteger('expert_price_id')->nullable();
        //     $table->string('keyword')->nullable();
        //     $table->string('refrence_link')->nullable();
        //     $table->string('anchor_text')->nullable();
        //     $table->string('reference')->nullable();
        //     $table->unsignedBigInteger('category_id')->nullable();
        //     $table->text('brief_note')->nullable();
        //     $table->string('attachment')->nullable();
        //     $table->string('status')->default('pending');
        //     $table->decimal('price', 10, 2)->nullable();
        //     $table->decimal('total', 10, 2)->nullable();
        //     $table->date('due_date')->nullable();
        //     $table->time('due_time')->nullable();
        //     $table->string('country_name')->nullable();

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('order_attributes');
    }
};
