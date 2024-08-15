<?php

namespace SteelAnts\LivewireForm\Livewire;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\View\AnonymousComponent;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\Concerns\ManagesComponents;
use SteelAnts\Form\View\Components\Form;

class FormComponent extends Component
{
  public array $fields = [];
  public array $properties = [];

  private function getFields(): array
  {
    return $this->fields;
  }

  public function store(){
    if (method_exists($this, 'rules')){
      $this->validate();
    }

    dd($this->properties);
  }

  // Transform whole field on output (optional)
  // !!! NOTE: values are rendered with {!! !!}, manually escape values
  // public function renderField(array $field) : string
  // {
  //     return [
  //         'id' => e($row['id'])
  //     ];
  // }

  public function render()
  {
      return view('form-components::container', ['fields' => $this->getFields()]);
  }
}
