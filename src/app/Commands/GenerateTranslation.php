<?php

namespace processdrive\rap\Commands;

use Illuminate\Console\Command;

class GenerateTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rap_generate:translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Roles and permision tranlation Generator';

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
        $role = new \processdrive\rap\Models\GetRoutes();
        $role->createTransFiles();
        echo "\033[32m Translation is created Successfully! \033[0m".PHP_EOL;
    }
}
