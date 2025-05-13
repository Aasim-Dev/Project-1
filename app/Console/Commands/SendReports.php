<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\ReportMail;

class SendReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reports';

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
       User::where('user_type', 'Advertiser')->each(function($user){
        \Mail::to($user->email)->send(new ReportMail());
       });
       $this->info('Reports Send Successfully');
    }
}
