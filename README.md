# Twill API

Provide a read-only API to Twill models and entities along with base structure to create your own JSON:API compliant REST API. This package is based on and requires the excellent [Laravel JSON:API](https://github.com/laravel-json-api/laravel) package.

## Installation

This package needs a Laravel project with Twill already set up.

### Install Laravel JSON:API

Follow the steps outlined in the Laravel JSON:API [documentation](https://laraveljsonapi.io/docs/3.0/getting-started/).

Update `config/jsonapi.php` with the namespace you would like to use.

```diff
-    'namespace' => 'JsonApi',
+    'namespace' => 'TwillApi',
```

### Install Twill API

```bash
composer require area17/twill-api
```

Publish config file `config/twill-api.php` and migrations. Apply migrations.

```bash
php artisan vendor:publish --tag=twill-api-config
php artisan vendor:publish --tag=twill-api-migrations
php artisan migrate
```

Create you base `Server.php` class

```bash
php artisan twill:make:server
```

Update `config/jsonapi.php` `servers` key with your newly created `Server` class.

```diff
'servers' => [
- //    'v1' => \App\JsonApi\V1\Server::class,
+    'v1' => \App\TwillApi\V1\Server::class,
],
```

If you want to make you API public (which is convenient early in development), you can update the `authorisable` method in your `Server` class.

```diff
    function authorizable(): bool
    {
-         return true;
+         return false;
    }
```

Add API middlewares you the `api` group in `app/Http/Kernel.php`. See below for a list of the available middlewares.

## Middlewares

### Middleware to set locale

To query the API by adding the locale query string to the url. For example `https://example.com/api/v1/books?locale=fr` will give you the results available in the French (fr) locale.

```php
    protected $middlewareGroups = [
        // ...
        
        'api' => [
            \A17\Twill\API\Http\Middleware\SetLocale::class,
            // ...
```

### Middleware to remove unpublished content

from browser fileds and features.
```php
    protected $middlewareGroups = [
        // ...
        
        'api' => [
            \A17\Twill\API\Http\Middleware\EnableFeaturePublishedScope::class,
            \A17\Twill\API\Http\Middleware\EnableRelatedItemPublishedScope::class,
            // ...
```

## Traits

Whenever your models has media or files attached to them, you must add the traits provided in this package in order to expose a relationship to the pivot models for each (by default it is the `mediables` and `fileables` tables).

If your model also have children blocks (saved through repeater inside a block), you must add the `HasChildBlocks` for the API to respect the parent/child relation in the API response.  

```php
use A17\Twill\API\Models\Traits\HasChildBlocks;
use A17\Twill\API\Models\Traits\HasFileables;
use A17\Twill\API\Models\Traits\HasMediables;

class Page
{
    use HasChildBlocks, HasFileables, HasMediables;
    
    // ...
}
```

## Create a resource schema and API route

To create a basic schema for a new resource (model), use the artisan command `twill:make:schema`. Pass the name of the Twill module as the argument.

```bash
php artisan twill:make:schema snippets
```

This command will create `app/TwillApi/V1/Snippets/SnippetSchema.php`. The command will display a few instructions to register the new schema with the API server and how to declare the endpoint in you `routes/api.php`.

For what is available from there, consult the Laravel JSON:API documentaiton under the [Schemas](https://laraveljsonapi.io/docs/2.0/schemas/) section.

Your new endpoint should now be available at `http://localhost/api/v1/snippets`.

## Resources

### Endpoints

This package provides these endpoints along with their schema:

- `/api/v1`
- `/api/v1/blocks`
- `/api/v1/blocks/{id}`
- `/api/v1/features`
- `/api/v1/features/{id}`
- `/api/v1/files`
- `/api/v1/files/{id}`
- `/api/v1/media`
- `/api/v1/media/{id}`
- `/api/v1/related-items`
- `/api/v1/related-items/{id}`
- `/api/v1/tags`
- `/api/v1/tags/{id}`
- `/api/v1/settings`
- `/api/v1/settings/{id}`
- `/api/v1/users`
- `/api/v1/users/{id}`

### Blocks

(to do)

### Browser fields (related items)

(to do)

### Features

(to do)

## Use API tokens to show unpublished content

(to do)
