<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class Download extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'command:download
                            {realpath : full path of a picture (required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Download';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(config('filesystems.default') == 'local')
        {
            $this->task("The default file systems is local", function (){
                return false;
            });
        }
        else{
            $realpath = $this->argument('realpath');
            if($this->validation($realpath))
            {
                Storage::copy($realpath, storage_path().'_'.Carbon::now()->timestamp);
                $this->task("File ".$realpath." Stored?", function (){
                    return true;
                });
            }
            else {
                $this->task("File ".$realpath." Stored?", function (){
                    return false;
                });
            }
        }
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
