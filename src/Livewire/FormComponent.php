<?php

namespace SteelAnts\LivewireForm\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Blade;

class FormComponent extends Component
{
    public array $properties = [];
    public string $viewName = 'form-components::container';

    public function mount(){
        $this->properties = $this->properties();
    }

    #[Computed()]
    public function fields()
    {
        return [];
    }

    public function properties()
    {
        return [];
    }

    #[Computed()]
    public function types()
    {
        return [];
    }

    #[Computed()]
    public function labels()
    {
        return [];
    }

     #[Computed()]
    public function helps()
    {
        return [];
    }

    #[Computed()]
    public function options()
    {
        $options = [];
        foreach ($this->fields as $key) {
            $optionMethodName = Str::camel($key . '_options');
            if (method_exists($this, $optionMethodName)) {
                $options[$key] = $this->$optionMethodName();
                continue;
            }

            if (method_exists($this, 'getOptions')) {
                $opts = $this->getOptions($key, $options);
                if(!empty($opts)){
                    $options[$key] = $opts;
                }
            }
        }
        return $options;
    }

    #[Computed()]
    public function mentions()
    {
        return [];
    }

    public function store()
    {
        try {
            if (method_exists($this, 'rules')) {
                $this->validate();
            }

            $error = true;
            if (method_exists($this, 'submit')) {
                $error = !$this->submit();
            } else {
                $error = !dd($this->properties);
            }

            if ($error && method_exists($this, 'onError')) {
                $this->onError();
            } else if (method_exists($this, 'onSuccess')) {
                $this->properties = $this->properties();
                $this->onSuccess();
            }
        } catch (ValidationException $e) {
            $this->resetErrorBag();
            foreach ($e->validator->errors()->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $this->addError($field, str_replace("properties.", "", $message));
                }
            }
            $this->onError();
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

    public function render()
    {
        return view($this->viewName);
    }

    /**
     * Render field
     */
    protected function field($field)
    {
        return Blade::render(<<<'BLADE'
            <x-form-components::field
                :field="'properties.'.$field"
                :label="$label"
                :help="$help"
                :type="$types"
                :options="$options"
                :mentions="$mentions"
            />
        BLADE, [
            'field' => $field,
            'label' => $this->labels[$field] ?? $field,
            'help' =>  $this->helps[$field] ?? null,
            'types' => $this->types[$field] ?? null,
            'options' => $this->options[$field] ?? null,
            'mentions' => $this->mentions ?? null,
        ]);
    }
}
