<?php

namespace SteelAnts\LivewireForm\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class FormComponent extends Component
{
    function __construct(){

        for($i=0;$i<100;$i++)
        {
 
          $varname='var'.$i;
          $this->{$varname}=$i;
        }
     }
}