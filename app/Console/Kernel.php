<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Chapter\Console\ActiveScheduleChapter;
use Modules\Course\Console\ActiveScheduleCourse;
use Modules\Lesson\Console\ActiveScheduleLesson;
use Modules\NotificationCenter\Console\SendNotification;
use Modules\Permission\Console\SyncPermissions;
use Modules\Program\Console\ActiveScheduleProgram;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncPermissions::class,
        ActiveScheduleProgram::class,
        ActiveScheduleCourse::class,
        ActiveScheduleChapter::class,
        ActiveScheduleLesson::class,
        SendNotification::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('active:program')->everyMinute();
        $schedule->command('active:course')->everyMinute();
        $schedule->command('active:chapter')->everyMinute();
        $schedule->command('active:lesson')->everyMinute();
        $schedule->command('send:schedule-notification')->everyMinute();
        $schedule->command('queue:work')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
