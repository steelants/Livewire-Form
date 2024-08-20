<?php

namespace SteelAnts\LivewireForm\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

trait HasModel
{
    // If you vant to manipulate with model you need to 
    public $modelObject;

    public function submit(): bool
    {
        if (method_exists($this, 'rules')) {
            $this->validate();
        }

        if ($this->resolveModel()->id !== null) {
            try {
                $this->resolveModel()->update($this->properties);
            } catch (\Illuminate\Database\QueryException $e) {
                return false;
            }
        } else {
            if(!$this->resolveModel()::create($this->properties)){
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
        if ($this->resolveModel()->id !== null) {
            $rawProperties = $this->resolveModel()->toArray();

            foreach ($rawProperties as $key => $value) {
                $rawProperties[$key] = (isset($this->types()[$key]) && str_starts_with($this->types()[$key], "date") ? Carbon::parse($value)->format('Y-m-d') : $value);
            }

            return $rawProperties;
        }

        return [];
    }

    public function types()
    {
        return $this->resolveModel()->getCasts();
    }

    public function options()
    {
        $options = [];
        foreach ($this->properties() as $key => $value) {
            if (str_ends_with($key, '_id')) {
                $relatedModel = Str::camel(str_replace("_id", "", $key));
                $options[$key] = $this->resolveModel()->$relatedModel->getModel()->all()->pluck('name', 'id')->toArray();
            }
        }
        return $options;
        // dump($this->resolveModel()->getRelations());
        //dd(get_class_methods($this->resolveModel()));
    }

    public function resolveModel()
    {
        if (!empty($this->modelObject)) {
            return $this->modelObject;
        }

        if (empty($this->model_id)) {
            $classname = $this->model;
            $this->modelObject = new $classname();
            return $this->modelObject;
        }

        $this->modelObject = $this->model::find($this->model_id);
        return $this->modelObject;
    }
}
