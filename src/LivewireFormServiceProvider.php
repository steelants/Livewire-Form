<?php

namespace SteelAnts\LivewireForm;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class LivewireFormServiceProvider extends ServiceProvider
{
    public function boot(Request $request)
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/components', 'form-components');
    }

    public function register()
    {
    }
}