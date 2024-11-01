<?php

namespace Modules\Program\Console;

use Illuminate\Console\Command;
use Modules\Program\Entities\Program;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class ActiveScheduleProgram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'active:program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Active schdeuled program.';

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
        Program::withTrashed()->whereNotNull('schedule')->where('schedule', '<=', Carbon::now())->update([
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
