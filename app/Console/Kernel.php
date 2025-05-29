<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('emails:send')->everyMinute();
        $schedule->command('app:send-reports')->everyMinute()->runInBackground();
        $schedule->command('app:order-reminder-mail')->weekdays()->everyminute()->timezone('Asia/Kolkata');
        $schedule->command('app:price-update-mail')->everyMinute();
        $schedule->command('app:websites-checked-mail')->everyMinute();
        $schedule->command('app:send-all-report-to-admin')->everyDay()->at('10:00');
        $schedule->job(new \App\Jobs\EmailReminderJob)->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
