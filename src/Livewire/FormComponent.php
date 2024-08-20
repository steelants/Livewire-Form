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
use SteelAnts\LivewireForm\Traits\HasModel;

class FormComponent extends Component
{
  public array $properties = [];
  private array $types = [];
  private array $fields = [];

  private function getFields(): array
  {
    if (method_exists($this, 'fields')) {
      $this->fields = $this->fields();
    }

    return $this->fields;
  }

  private function getProperties()
  {
    if (method_exists($this, 'properties')) {
      $this->properties = $this->properties();
    }

    return $this->properties;
  }

  private function getTypes()
  {
    if (method_exists($this, 'types')) {
      $this->types = $this->types();
    }

    return $this->types;
  }

  public function store()
  {
    if (method_exists($this, 'rules')) {
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
   
    return view('form-components::container', [
      'fields' => $this->getFields(),
      'properties' => $this->getProperties(),
      'types' => $this->getTypes(),
    ]);
  }
}
