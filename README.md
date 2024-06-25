# Livewire-Form

### Dev Enviroment
1) Clone Repo to `[LARVEL-ROOT]packages/`
2) Modify ;composer.json`
```json
    "autoload": {
        "psr-4": {
            ...
            "SteelAnts\\LaravelBoilerplate\\": "packages/laravel-boilerplate/src/"
            ...
        }
    },
```
3) Add (code below) to: `[LARVEL-ROOT]packages/bootstrap/providers.php`
```php
SteelAnts\LaravelBoilerplate\BoilerplateServiceProvider::class,
```