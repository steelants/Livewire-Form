<?php

namespace SteelAnts\LivewireForm\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Field extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $field = null,
        public $label = null,
        public $help = null,
        public $type = null,
        public $options = null,
        public $mentions = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return 'form-components::field';
    }
}
