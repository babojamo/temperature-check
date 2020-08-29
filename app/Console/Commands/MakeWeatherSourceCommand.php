<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeWeatherSourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:weathersource {sourceClass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a weather source';

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
     * @return int
     */
    public function handle()
    {
        

        $sourceClass=$this->argument('sourceClass');

        if(empty($sourceClass))
        {
            $this->error("Please indicate a weather source name!");
            return null;
        }

        $this->comment('Generating weather source');

        // Get the class template
        $template=file_get_contents(base_path()."/app/Temperature/Template/WeatherSource.php");
        $template=str_replace("WeatherSource",$sourceClass,$template);

        // Generate class file name
        $filename="{$sourceClass}.php";
        $filepath="app/Temperature/WeatherServices/{$filename}";

        // File existence checking 
        if(file_exists($filepath))
        {
            $this->error("Weather source is already exists!");
            return null;
        }

        // Generate the file
        file_put_contents($filepath,$template);


        $this->info('');
        $this->comment('Please generate the api configuration manually, see docs');
        $this->info('https://github.com/babojamo/temperature-check#readme');
        $this->info('');
        $this->info('');

        $this->info('Weather source has been successfully generated!');

        return 0;
    }
}
