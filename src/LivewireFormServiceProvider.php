<?php

namespace SteelAnts\LivewireForm;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use SteelAnts\LivewireForm\Console\Commands\MakeCommand;

class LivewireFormServiceProvider extends ServiceProvider
{
    public function boot(Request $request)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views/components', 'form-components');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'livewire-form');
    }

    public function register()
    {
    }
}