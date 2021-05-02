<?php

namespace App\Console\Commands;

use App\Contracts\Database\Refresher;
use Illuminate\Console\Command;

class FetchFruits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fruits:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch fruit data from Appoly server';

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
    public function handle(Refresher $refresherService)
    {
        $refresherService->refreshData('\App\Services\Database\FruitRepository', config('app.fetch_fruit_url'));
    }
}
