<?php

namespace Modules\NotificationCenter\Console;

use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Modules\NotificationCenter\Entities\Notification;
use Modules\NotificationCenter\Entities\NotificationUser;
use Modules\NotificationCenter\Jobs\ProcessNotification;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:schedule-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send schedule notification to users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $to = Carbon::now()->addMinutes(2);
        $notifications = Notification::where('status', 2)->whereDate('schedule', '<=', $to)->get();

        foreach($notifications as $notification) {

            try{
                $users = $notification->parentUsers;
                $media = $notification->media->pluck('medium_id')->toArray();

                if($notification->status == 2 && in_array(0, $media) || in_array(1, $media)) {
                    // $users = $users->whereNotNull('email')->where('email', '!=', 'admin@demo.coms');
                    dispatch(new ProcessNotification($users, $notification));
                }
                
                NotificationUser::where('notification_id', $notification->id)->update([
                    'is_seen' => 0
                ]);

                $notification->status = 1;
                $notification->save();
            } catch (Exception $e) {
                \Log::info('Notification Schedule Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::OPTIONAL, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
