<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Mail\ReportMail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderRemider;
use App\Helper\MailHelper;
use App\Models\Post;

class OrderReminderMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-reminder-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function __construct(){
        parent::__construct();
    }

    public function handle()
    {
        $orders = Order::select(
            'orders.*',
            'users.*',
            'orders.created_at as order_created_at'
        )
        ->join('users', 'users.id', 'orders.advertiser_id')
        ->where('orders.status', 'new')
        ->get();

        $getData = Order::select('orders.*', 'posts.*', 'users.*', 'orders.created_at as order_created_at')
        ->leftJoin('posts', 'posts.id', 'orders.website_id')
        ->leftJoin('users', 'users.id', 'posts.user_id')
        ->where('orders.status', 'new')
        ->orderBy('orders.id', 'DESC')
        ->get();
        if($orders->isEmpty()) {
            Log::info("No orders found for reminder email.");
            $this->info("No orders matched the criteria.");
            return;
        }
        foreach(array_map(null, $orders->all(), $getData->all()) as [$order, $data]){
            Log::info("Order email: " . $order->email);
            $this->info("Sending to: " . $order->email);
            if ($order->email) {
                Log::info($data['order_created_at']);
                $date = $data['order_created_at'];
                $now = date('Y-m-d H-i');
                $date = date('Y-m-d H-i', strtotime('23 hours', strtotime($date)));
                if($now == $date){
                    \Log::info("Sending email to " . $data['email']); //just for debugging                    
                    $mail = MailHelper::orderReminder($data);
                    $this->info("Order Reminder Email Sent to " . $data['email']);
                }elseif($now >= $date){
                    \Log::info("Sending email to " . $data['email']); 
                    \Log::info("No orders found for 1 Hour Reminder Email.");
                    $mail = MailHelper::orderRejectMail($data);
                    $this->info("Order Rejected Due to 24 Hours " . $data['email']);
                }else{
                    $this->info("No Orders Found For Reminder Email.");
                }
                $this->info('All reminder mails processed.');
            }
        }
        
        
        
    }
}
