# Usage

SteelAnts Livewire-Form provides a `FormComponent` base class for building model forms.

With the `HasModel` trait the form resolves fields, types and values automatically from the model.


## Creating a Form

Generate a form component:

```bash
php artisan livewire-form:make Form --model=User
```

Or create it manually:

```php
namespace App\Livewire\User;

use App\Models\User;
use SteelAnts\LivewireForm\Livewire\FormComponent;
use SteelAnts\LivewireForm\Traits\HasModel;

class Form extends FormComponent
{
    use HasModel;

    public $modelClass = User::class;
}
```

Fields are resolved from the model `$fillable` and input types from the model `$casts`.


## Rendering the Form

Create a new record:

```blade
<livewire:user.form />
```

Edit an existing record by passing the model id:

```blade
<livewire:user.form model-id="2" />
```

The submit button label switches automatically between Create and Update.


## Validation Rules

Default rules are generated from the model `$fillable`.

You can define your own rules; field names use the `properties.` prefix:

```php
protected function rules()
{
    return [
        'properties.name' => 'required|max:255',
        'properties.email' => 'required|string|email|max:255|unique:users,email' . ($this->model->exists() ? ',' . $this->model->id : ''),
    ];
}
```


## Labels

Labels are generated from the field names.

You can override them:

```php
public function labels()
{
    return [
        'name' => __('Name'),
        'email' => __('Email'),
    ];
}
```


## Callbacks

React to the form submission result:

```php
public function onSuccess()
{
    // called after a successful submit
}
```

```php
public function onError()
{
    // called when the submit fails
}
```


## Submit Flow

Submitting the form calls `store()`:

1. Validation runs when `rules()` returns a non-empty array.
2. `submit()` creates a new record or updates the existing one.
3. On success the properties are reset and `onSuccess()` is called.
4. On failure `onError()` is called.


## Complete Example

```php
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

    public function labels()
    {
        return [
            'name' => __('Name'),
            'email' => __('Email'),
            'password' => __('Password'),
            'password_confirmation' => __('Password confirmation'),
        ];
    }

    public function onSuccess()
    {
        // ...
    }

    public function onError()
    {
        // ...
    }
}
```


## Next Steps

Continue with:

- [Fields](fields.md)
- [Commands](commands.md)
