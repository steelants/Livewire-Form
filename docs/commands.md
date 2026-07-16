# Commands

SteelAnts Livewire-Form provides one Artisan command.


## livewire-form:make

Generates a form component for a model.

```bash
php artisan livewire-form:make Form --model=User
```

| Argument / Option | Description |
|---|---|
| `formName` | Name of the generated class (default `Form`) |
| `--model=` | Model class name from `App\Models` (required) |
| `--force` | Overwrite existing files without confirmation |

The command generates:

```
app/Livewire/{Model}/{FormName}.php
```

The generated component uses the `HasModel` trait and contains validation rules based on the model `$fillable`.


## Next Steps

Continue with:

- [Usage](usage.md)
- [Fields](fields.md)
