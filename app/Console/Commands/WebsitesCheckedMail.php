<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\UrlChecker;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WebsitesVerifiedMail;

class WebsitesCheckedMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:websites-checked-mail';

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
        $websites = DB::table('url_checker')->where('checked', 0)
                    ->orderBy('id', 'ASC')
                    ->limit(25)
                    ->get();

        $batch = $websites->groupBy('batch_id');
        //dd($batch);

        foreach($batch as $batchId => $batchWebsites){
            UrlChecker::whereIn('id', $batchWebsites->pluck('id'))->update(['checked' => 1]);
            $userId =$batchWebsites->first()->user_id;
            try{
                $userBatchPending = UrlChecker::where('batch_id', $batchId)->where('user_id', $userId)
                                    ->where('checked', 0)->exists();
                //dd($userBatchPending);
                if(!$userBatchPending){
                    $user = User::find($userId);
                    Mail::to($user->email)->send(new WebsitesVerifiedMail($user));
                }
            }catch(\Exception $e){
                Log::error('Error Sending Mail' . $e->getMessage());
            }
        }
    }
}
