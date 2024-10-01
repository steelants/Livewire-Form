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
  private array $options = [];

  private function getFields(): array
  {

    if ($this->fields != [])
      return $this->fields;

    if (method_exists($this, 'fields')) {
      $this->fields = $this->fields();
    }

    return $this->fields;
  }

  private function getProperties()
  {
    if (method_exists($this, 'properties')) {
      $this->properties = $this->properties();
      unset($this->properties['id']);
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

  public function getOptions()
  {
    if ($this->options != [])
      return $this->options;

    $options = [];
    foreach ($this->getProperties() as $key => $value) {
      $optionMethodName = Str::camel('get_' . $key . '_options');
      if (method_exists($this, $optionMethodName)) {
        $options[$key] = $this->$optionMethodName();
        continue;
      }

      if (method_exists($this, 'options') && $this->options($key, $options) !== []) {
        $options[$key] = $this->options($key, $options);
      }
    }
    
    
    $this->options = $options;


    return $this->options;
  }

  private function getLabels()
  {
    if (method_exists($this, 'labels')) {
      return $this->labels();
    }

    return $this->getFields();
  }

  public function store()
  {
    if (method_exists($this, 'rules')) {
      $this->validate();
    }

    $error = true;
    if (method_exists($this, 'submit')) {
      $error = !$this->submit();
    } else {
      $error =  !dd($this->properties);
    }

    if ($error && method_exists($this, 'onError')) {
      $this->onError();
    } elseif (method_exists($this, 'onSuccess')) {
      $this->reset('properties');
      $this->onSuccess();
    }
  }

  // Transform whole field on output (optional)
  // !!! NOTE: values are rendered with {!! !!}, manually escape values
  // public function renderField(array $field) : string
  // {
  //     return [
  //         'id' => e($row['id'])
  //     ];
  // }

  // Overide options for select of field in default all otions gnnerated are used (optional)
  // public function getPropertyNameOptions() : array
  // {
  //     return [
  //         'id' => 'name'
  //     ];
  // }

  public function render()
  {
    return view('form-components::container', [
      'fields' => $this->getFields(),
      'properties' => $this->getProperties(),
      'types' => $this->getTypes(),
      'options' => $this->getOptions(),
      'labels' => $this->getLabels(),
    ]);
  }
}
