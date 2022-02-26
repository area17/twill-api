# Twill API

Provide a read-only API to Twill models and entities.
## Installation

### Install the `twill-api` package
```
composer require area17/twill-api
```

### Add `SetLocale` middleware

Twill API is using the `api` middleware group provided by default by Laravel. If your content is multilingual and for the API to return the results in the right locale, you need to add this middleware to `app/Http/Kernel.php`.

You can query the API by adding the locale query string to the url. For example `https://example.com/api/v1/books?locale=fr` will give you the results available in the French (fr) locale.

```php
    protected $middlewareGroups = [
        // ...

        'api' => [
            // ...
            \A17\Twill\API\Http\Middleware\SetLocale::class,
        ],
    ];
```

### Create the resource controller and register the endpoints

 This artisan command will create `app/Http/Controllers/API/BookController.php` and will assume its model to be `App\Models\Book`.

```bash
php artisan twill-api:make:controller books
```

In `routes/api.php`, you can register you modules with the macro `moduleResource`.

```php
Route::moduleResource('books');
```


Two endpoints are now available:

- `/api/v1/books`
- `/api/v1/books/{id}`

## Endpoints

List of available endpoints:

- `/api/v1`
- `/api/v1/blocks`
- `/api/v1/blocks/{id}`
- `/api/v1/files`
- `/api/v1/files/{id}`
- `/api/v1/media`
- `/api/v1/media/{id}`
- `/api/v1/features`
- `/api/v1/features/{id}`
- `/api/v1/users`
- `/api/v1/users/{id}`
- `/api/v1/tags`
- `/api/v1/tags/{id}`
- `/api/v1/settings`
- `/api/v1/settings/{id}`
