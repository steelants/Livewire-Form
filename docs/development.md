# Development

This guide describes how to develop SteelAnts Livewire-Form locally inside a Laravel application.


## Local Setup

Create a packages directory and clone the repository:

```bash
mkdir packages
git clone https://github.com/steelants/Livewire-Form.git ./packages/Livewire-Form
```

Update the autoload section of your application `composer.json`:

```json
"autoload": {
    "psr-4": {
        "SteelAnts\\LivewireForm\\": "packages/Livewire-Form/src/"
    }
}
```

Refresh the autoloader:

```bash
composer dump-autoload
```

Register the service provider in `bootstrap/providers.php`:

```php
return [
    // ...
    SteelAnts\LivewireForm\LivewireFormServiceProvider::class,
];
```


## Development Workflow

1. Create a feature branch.
2. Implement changes.
3. Verify the components in a test application.
4. Merge changes into the development branch.


## Next Steps

Continue with:

- [Usage](usage.md)
- [Fields](fields.md)
