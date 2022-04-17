<?php

namespace App\Console;

use App\Models\EmailVerifyToken;
use App\Models\SeatInfo;
use App\Models\Token;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Set ticket status completed
        $schedule->call(function () {
            SeatInfo::where('start_time', '<', gmdate("Y-m-d H:i:s", time()))->update(["status" => "Completed"]);
        })->cron("* * * * 0");

        // Delete unused email verification token and disable link
        $schedule->call(function () {
            EmailVerifyToken::where('created_at', '<', gmdate("Y-m-d H:i:s", time() - 1800))->delete();
        })->cron("* * * * 0");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
