<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use Carbon\Carbon;
use App\Mail\PriceUpdateMailtoAdv;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use DB;

class PriceUpdateMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:price-update-mail';

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
        $getData = DB::table('cart')->select('cart.*', 'users.name as name', 'users.user_type as user_type', 'users.email as email')
                    ->join('users', 'users.id', '=', 'cart.advertiser_id')
                    ->where('users.user_type', '=', 'Advertiser')
                    ->where('cart.created_at', '<=', Carbon::now()) // here it will be >= Carbon::now()->addDay
                    ->get();
        //dd($getData);
        foreach($getData as $data){
            if($data){
                try{
                    Mail::to($data->email)->send(new PriceUpdateMailtoAdv($data));
                    DB::table('cart')->where('id', $data->id)->update([
                        'guest_post_price' => ($data->guest_post_price) - ($data->guest_post_price * 0.10), 
                        'linkinsertion_price' => ($data->linkinsertion_price) - ($data->linkinsertion_price * 0.10),
                    ]);
                }catch(\Exception $e){
                    Log::error('Error in Sending Mail and Giving Discount' . $e->getMessage());
                }
            }
        } 
    }
}
