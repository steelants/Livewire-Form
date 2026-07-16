<div align="center">

<a href="https://steelants.cz">
	<picture>
		<source
			media="(prefers-color-scheme: dark)"
			srcset="https://steelants.cz/wp-content/uploads/2026/07/white_3.png">
		<img
			src="https://steelants.cz/wp-content/themes/wp_steelants_v5/img/logo.png"
			alt="SteelAnts"
			width="180">
	</picture>
</a>

<h1>Livewire-Form</h1>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/steelants/livewire-form.svg?style=flat-square)](https://packagist.org/packages/steelants/livewire-form) [![Total Downloads](https://img.shields.io/packagist/dt/steelants/livewire-form.svg?style=flat-square)](https://packagist.org/packages/steelants/livewire-form)

<p>
Model driven Livewire form components for Laravel - fields, types, labels and validation resolved automatically from your Eloquent models.
</p>

<p>
Created by <a href="https://steelants.cz">SteelAnts s.r.o.</a>
</p>

</div>

## Installation

Install the package using Composer:

```bash
composer require steelants/livewire-form
```

## Features

SteelAnts Livewire-Form provides:

- Livewire form components for creating and updating models
- Fields resolved from the model `$fillable`
- Input types resolved from the model `$casts`
- Automatic create vs. update handling
- Relation selects for `_id` fields
- Custom field rendering
- Success and error callbacks
- Form generator command

## Usage

Create a form component for a model:

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

Render the component:

```blade
<livewire:user.form />

<livewire:user.form model-id="2" />
```

## Documentation

- [Installation](docs/installation.md)
- [Usage](docs/usage.md)
- [Fields](docs/fields.md)
- [Commands](docs/commands.md)
- [Development](docs/development.md)

## Contributors

<a href="https://github.com/steelants/Livewire-Form/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=steelants/Livewire-Form" />
</a>

## Other Packages

- [laravel-auth](https://github.com/steelants/laravel-auth)
- [Livewire-DataTable](https://github.com/steelants/Livewire-DataTable)
- [Laravel-Boilerplate.Warehouse](https://github.com/steelants/Laravel-Boilerplate.Warehouse)
- [Laravel-Boilerplate](https://github.com/steelants/Laravel-Boilerplate)
- [Laravel-Form](https://github.com/steelants/Laravel-Form)
- [Laravel-General](https://github.com/steelants/Laravel-General)
- [Laravel-Tenant](https://github.com/steelants/Laravel-Tenant)
- [Livewire-Modal](https://github.com/steelants/Livewire-Modal)

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
