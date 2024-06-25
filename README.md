# Livewire-Form

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