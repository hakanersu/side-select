<?php

namespace Xuma\SideSelect;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class SideSelectServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/livewire', 'sideselect');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'sideselect');
        Livewire::component('side-select', SideSelect::class);
    }
}
