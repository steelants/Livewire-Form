# Fields

SteelAnts Livewire-Form renders fields automatically based on the model casts.

The underlying inputs are provided by the steelants/form package.


## Field Types

| Type | Rendered element |
|---|---|
| `string` | Text input |
| `text` | Textarea |
| `int` | Number input |
| `checkbox` | Checkbox |
| `date` | Date input |
| `datetime` | Datetime input |
| `quill` | Quill rich text editor |
| `hashed` | Two password inputs with confirmation |

Fields without a type render as a text input.

Fields with options render as a select.


## Types from Casts

With the `HasModel` trait the types are resolved from the model `$casts`:

```php
protected $casts = [
    'published_at' => 'date',
    'is_active' => 'checkbox',
    'content' => 'quill',
    'password' => 'hashed',
];
```


## Relation Selects

Fields ending in `_id` are resolved automatically as relation selects.

Example field `category_id`:

1. The relationship name `category` is derived from the field name.
2. All records of the related model are loaded.
3. A select with `name => id` options is rendered.


## Custom Options

You can define options for a specific field using a `{field}Options()` method:

```php
public function statusOptions()
{
    return [
        'draft' => 'Draft',
        'published' => 'Published',
    ];
}
```


## Help Texts

You can define help texts per field:

```php
public function helps()
{
    return [
        'email' => __('The e-mail is used for login.'),
    ];
}
```


## Custom Field Rendering

A field can be rendered completely manually using a `renderField{FieldName}()` method:

```php
public function renderFieldName()
{
    return view('livewire.user.custom-name-field')->render();
}
```

The method name is based on the field name.

Example:

Field:

```php
'name'
```

Method:

```php
renderFieldName()
```


## Next Steps

Continue with:

- [Usage](usage.md)
- [Commands](commands.md)
