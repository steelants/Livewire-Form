# Livewire-Form

### Basic Form Component For Creation/Update of model
```php
<?php
namespace App\Livewire\PersonChild;

use App\Models\PersonChild;
use SteelAnts\LivewireForm\Livewire\FormComponent;
use SteelAnts\LivewireForm\Traits\HasModel;

class Form extends FormComponent
{
    use HasModel;

    public $modelClass = PersonChild::class;

    //default rules generated from $fillables of model or define own if you are not using them HasModel Attribute
    protected function rules()
    {
        return [
            'properties.name' => 'required',
        ];
    }

    //Oweride default labels generated from $fillables of model or define own if you are not using them HasModel Attribute
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
```blade
@livewire('form-test', ['model' => 2])
```

### User For Form Component example
```html
Edit user - pass model-id attribute
<livewire:user.form model-id="2" />

Create user
<livewire:user.form/>
```
```php
<?php
namespace App\Livewire\User;

use App\Models\User;
use SteelAnts\LivewireForm\Livewire\FormComponent;
use SteelAnts\LivewireForm\Traits\HasModel;

class Form extends FormComponent
{
    use HasModel;

    public $modelClass = User::class;

    protected function rules()
    {
        return [
            'properties.name' => 'required|max:255|unique:users,name',
            'properties.email' => 'required|string|email|max:255|unique:users,email' . ($this->model->exists() ? ',' . $this->model->id : ''),
            'properties.password' => 'sometimes|string|min:8|max:255',
            'properties.password_confirmation' => 'required_with:properties.password|string|same:properties.password',
        ];
    }

    //Oweride default labels generated from $fillables of model or define own if you are not using them HasModel Attribute
    function labels(){
        return [
            'name' => __('Name'),
            'email' => __('Email'),
            'password' => __('Password'),
            'password_confirmation' => __('Password confirmation')
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
