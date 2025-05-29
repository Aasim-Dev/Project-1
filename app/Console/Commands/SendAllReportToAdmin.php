<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendAllReportstoAdmin;
use App\Models\User;
use App\Models\Website;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Wallet;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DB;

class SendAllReportToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-all-report-to-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();
        $last15 = date('Y-m-d H-i-s', strtotime('-15 days', strtotime($today)));
        $last30 = date('Y-m-d H-i-s', strtotime('-30 days', strtotime($today)));

        $users1 = User::selectRaw("
                count(id) as total_users,
                count(case when deleted_at is null then 1 end) as active_users,
                count(case when user_type = 'advertiser' then 1 end) as advertisers,
                count(case when deleted_at is not null then 1 end) as inactive_users
        ")->withTrashed();
        
        $users2 = clone $users1;
        $users15 = $users1->whereBetween('created_at', [$last15, $today])->first();
        $users30 = $users2->whereBetween('created_at', [$last30, $today])->first();

        $totalUsers15 = $users15->total_users;
        $activeUsers15 = $users15->active_users;
        $inactiveUsers15 = $users15->inactive_users;
        $totalAdvertisers15 = $users15->advertisers;
        $totalUsers30 = $users30->total_users;
        $activeUsers30 = $users30->active_users;
        $inactiveUsers30 = $users30->inactive_users;
        $totalAdvertisers30 = $users30->advertisers;

        $wallets = DB::table('wallets')->select('wallets.*', 'users.name as name', 'users.user_type as user_type')
                ->join('users', 'users.id', '=', 'wallets.user_id')
                ->where('users.user_type', '=', 'Advertiser')
                ->where('wallets.payment_status', '=', 'COMPLETED')
                ->where('wallets.credit_debit', '=', 'credit')
                ->whereIn('wallets.order_type', ['add_fund', 'reward'])
                ->distinct('wallets.user_id')
                ->get();

        $wallet15 = $wallets->whereBetween('created_at', [$last15, $today])->count('wallets.user_id');
        $wallet30 = $wallets->whereBetween('created_at', [$last30, $today])->count('wallets.user_id');

        $orders1 = DB::table('orders')->selectRaw("
                    count(id) as totalOrders,
                    count(distinct website_id) as totalWebsites,
                    count(distinct advertiser_id) as advertiserWhoplacedOrder
                  ");

        $orders2 = clone $orders1;
        $orders15 = $orders1->whereBetween('created_at', [$last15, $today])->first();
        $orders30 = $orders2->whereBetween('created_at', [$last30, $today])->first();
        
        $totalOrders15 = $orders15->totalOrders;
        $advertiserplaced15 = $orders15->advertiserWhoplacedOrder;
        $totalWebsites15 = $orders15->totalWebsites;
        $totalOrders30 = $orders30->totalOrders;
        $advertiserplaced30 = $orders30->advertiserWhoplacedOrder;
        $totalWebsites30 = $orders30->totalWebsites;

        $data15 = [
            'totalUsers' => $totalUsers15,
            'activeUsers' => $activeUsers15,
            'inactiveUsers' => $inactiveUsers15,
            'totalAdvertisers' => $totalAdvertisers15,
            'wallet' => $wallet15,
            'totalOrders' => $totalOrders15,
            'advertiserplaced' => $advertiserplaced15,
            'totalWebsitesOrdered' => $totalWebsites15
        ];
        $data30 = [
            'totalUsers' => $totalUsers30,
            'activeUsers' => $activeUsers30,
            'inactiveUsers' => $inactiveUsers30,
            'totalAdvertisers' => $totalAdvertisers30,
            'wallet' => $wallet30,
            'totalOrders' => $totalOrders30,
            'advertiserplaced' => $advertiserplaced30,
            'totalWebsitesOrdered' => $totalWebsites30
        ];
        try{
            if($data15 || $data30){
                Mail::to('admin@gmail.com')->send(new SendAllReportstoAdmin($data15, $data30));
            }
            Log::info('Report Sent To Admin Successfully');
        }catch(\Exception $e){
            Log::error('Error Sending Report to Admin: ' .  $e->getMessage());
        }
    }
}
