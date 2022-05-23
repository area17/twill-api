# Twill API

Provide a read-only API to Twill models and entities.

## Installation

### Install the `twill-api` package

```
composer require area17/twill-api
```

### Publish

```
# Migrations
php artisan vendor:publish --tag=twill-api-migrations

# Config
php artisan vendor:publish --tag=twill-api-config
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

### Create the resource

To create a basic schema for a new resource (model), use the artisan command `twill:make:schema`. Pass the name of the Twill module as the argument.

```bash
php artisan twill:make:schema snippets
```

This command will create `app/TwillApi/V1/Snippets/SnippetSchema.php`. The command will display a few instructions to register the new schema with the API server and how to declare the endpoint in you `routes/api.php`.

For what is available from there, consult the Laravel JSON:API documentaiton under the [Schemas](https://laraveljsonapi.io/docs/2.0/schemas/) section.

## Endpoints

List of available endpoints:

- `/api/v1`
- `/api/v1/blocks`
- `/api/v1/blocks/{id}`
- `/api/v1/related-items`
- `/api/v1/related-items/{id}`
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
