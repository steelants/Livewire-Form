<?php

namespace SteelAnts\LivewireForm\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait HasModel
{
    // If you vant to manipulate with model you need to 
public $modelObject;
    public function store()
    {
        dd($this->properties);
        if (method_exists($this, 'rules')) {
            $this->validate();
        }

        if ($this->resolveModel()->id !== null) {
            $this->resolveModel()->update($this->properties);
        } else {
            $this->resolveModel()::create($this->properties);
        }
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
                $rawProperties[$key] = (isset($this->types()[$key]) && str_starts_with($this->types()[$key],"date") ? Carbon::parse($value)->format('Y-m-d') : $value);
            }

            return $rawProperties;
        }

        return [];
    }

    public function types()
    {
        return $this->resolveModel()->getCasts();
    }

    public function resolveModel()
    {
        if (!empty($this->modelObject)){
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
