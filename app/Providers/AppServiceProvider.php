<?php

namespace App\Providers;

use App\Contracts\Database\Refresher;
use App\Contracts\DataStructure\ParentReferenceTree;
use App\Services\Database\RefresherService;
use App\Services\DataStructure\FruitDataStructureService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        ParentReferenceTree::class => FruitDataStructureService::class,
        Refresher::class => RefresherService::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
