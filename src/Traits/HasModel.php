<?php

namespace SteelAnts\LivewireForm\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasModel
{
    // If you vant to manipulate with model you need to 
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

    public function fields()
    {
        return $this->resolveModel()->getFillable();
    }

    public function properties()
    {
        $rawProperties = array_fill_keys(ARRAY_KEYS(array_flip($this->resolveModel()->getFillable())), null);
        
        if ($this->resolveModel()->id !== null) {
            $rawProperties = $this->resolveModel()->toArray();
        }

        foreach ($rawProperties as $key => $value) {
            $rawProperties[$key] = (isset($this->types()[$key]) && str_starts_with($this->types()[$key], "date") ? Carbon::parse($value)->format('Y-m-d') : $value);
        }

        return $rawProperties;
    }

    public function types()
    {
        return $this->resolveModel()->getCasts();
    }

    public function options($field, $options = []): array
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
        if (!empty($this->model)) {
            if (!is_int($this->model)){
                return $this->model;
            } else {
                $model = $this->modelClass::find($this->model);
                if (!empty($model) && $model->count() > 0) {
                    $this->model = $model;
                    return $this->model;
                }
            }
        }

        $classname = $this->modelClass;
        $this->model = new $classname();
        return $this->model;
    }
}
