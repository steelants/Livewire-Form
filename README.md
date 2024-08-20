# Livewire-Form

### Basic Form Component For Creation/Update of model
```php
    n<?php
namespace App\Livewire;

use App\Models\PersonChild;
use SteelAnts\LivewireForm\Livewire\FormComponent;
use SteelAnts\LivewireForm\Traits\HasModel;

class FormTest extends FormComponent
{
    use HasModel;

    public $model = PersonChild::class;
    public $model_id = 2;

    //Overide default labels generated from $fillables of model or define own if you are not using them HasModel Attribute
    function labels(){
        return [
            'name' => __('Jméno')
        ];
    }

    function onSuccess(){
        //DO SOMETHING ON SUCESS;
    }

    function onError(){
        //DO SOMETHING ON ERROR;
    }
}
```

### Dev Enviroment
1) Clone Repo to `[LARVEL-ROOT]packages/`
2) Modify ;composer.json`
```json
    "autoload": {
        "psr-4": {
            ...
            "SteelAnts\\LivewireForm\\": "packages/livewire-form/src/"
            ...
        }
    },
```
3) Add (code below) to: `[LARVEL-ROOT]packages/bootstrap/providers.php`
```php
SteelAnts\LivewireForm\LivewireFormServiceProvider::class,
```


## Contributors
<a href="https://github.com/steelants/laravel-auth/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=steelants/laravel-auth" />
</a>

## Other Packages
[steelants/datatable](https://github.com/steelants/Livewire-DataTable)

[steelants/form](https://github.com/steelants/Laravel-Form)

[steelants/modal](https://github.com/steelants/Livewire-Modal)

[steelants/boilerplate](https://github.com/steelants/Laravel-Boilerplate)