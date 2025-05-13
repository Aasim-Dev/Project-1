<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Helper\MailHelper;
use App\Models\Cart;
use App\Models\User;
use App\Models\Post;

class EmailReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $getData = Order::select('orders.*', 'posts.*', 'users.*')
        ->join('posts', 'posts.id', 'orders.website_id')
        ->join('users', 'users.id', 'posts.user_id')
        ->where('orders.status', 'new')
        ->orderBy('orders.id', 'DESC')
        ->get();
        foreach($getData as $data){
            \Log::info('Checking order: ' . $data['id']); // optional log
            if($data['tat']){
                $date = $data['created_at'];
                $now = date('Y-m-d H-i');
                $date = date('Y-m-d H-i', strtotime('23 hours', strtotime($date)));
                
                if($date == $now){
                    \Log::info("Sending email to " . $data['email']); //just for debugging                    
                    $mail = MailHelper::orderReminder($data);
                }elseif($now >= strtotime('24 hours')){
                    \Log::info("Sending email to " . $data['email']); 
                    \Log::info("No orders found for 1 Hour Reminder Email.");
                    $mail = MailHelper::orderRejectMail($data);
                }
            }
        }
    }
}
