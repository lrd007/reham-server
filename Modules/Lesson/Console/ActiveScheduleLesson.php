<?php

namespace Modules\Lesson\Console;

use Illuminate\Console\Command;
use Modules\Lesson\Entities\Lesson;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class ActiveScheduleLesson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'active:lesson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        Lesson::withTrashed()->whereNotNull('schedule')->where('schedule', '<=', Carbon::now())->update([
            'schedule' => NULL,
            'deleted_at' => NULL,
        ]);
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
