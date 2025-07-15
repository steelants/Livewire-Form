<?php

namespace SteelAnts\LivewireForm\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

trait HasModel
{
    // public $modelClass;
    public $modelId;
    public $model;

    public function submit(): bool
    {
        if (method_exists($this, 'rules')) {
            $this->validate();
        }

        if (!empty($this->resolveModel()->getAttributes())) {
            try {
                $this->resolveModel()->update($this->properties);
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else {
            if (!$this->resolveModel()::create($this->properties)) {
                return false;
            }
        }

        return true;
    }

    #[Computed()]
    public function fields()
    {
        return $this->resolveModel()->getFillable();
    }

    public function properties()
    {
        if ($this->resolveModel()->id !== null) {
            $rawProperties = $this->resolveModel()->toArray();
            $rawProperties = array_filter($rawProperties, fn($k) => in_array($k, $this->fields), ARRAY_FILTER_USE_KEY);
        }else{
            $rawProperties = array_fill_keys($this->fields, null);
        }

        foreach ($rawProperties as $key => $value) {
            $rawProperties[$key] = (isset($this->types()[$key]) && str_starts_with($this->types()[$key], "date") ? Carbon::parse($value)->format('Y-m-d') : $value);
        }

        return $rawProperties;
    }

    #[Computed()]
    public function types()
    {
        return $this->resolveModel()->getCasts();
    }

    public function getOptions($field, $options = []): array
    {
        $relatedModel = Str::camel(str_replace("_id", "", $field));
        if (str_ends_with($field, '_id')) {
            if (!empty($this->resolveModel()->$relatedModel)){
                return $this->resolveModel()->$relatedModel->getModel()->all()->pluck('name', 'id')->toArray();
            }
        }

        return [];
    }

    public function resolveModel(): Model
    {
        // tomuto taky moc nerzumim, proc je to tak zlosite a ne proste jen fetch dle id modelu
        if (!empty($this->model) && !empty($this->model->getAttributes())){
            return $this->model;
        }else if (!empty($this->modelId)) {
            $model = $this->modelClass::find($this->modelId);
            if (!empty($model)) {
                $this->model = $model;
                return $this->model;
            }
        }
        $classname = $this->modelClass;
        $this->model = new $classname();
        return $this->model;
    }
}
