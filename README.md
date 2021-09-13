# Installation

```sh
composer create-project laravel/laravel demo
cd demo
composer require artcoder/ladmin
```

```json
// composer.json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "modules/"
    }
  }
}
```

```sh
mkdir modules
composer dump-autoload
```

```php
// config/auth.php
'providers' => [
  'users' => [
    'driver' => 'eloquent',
    'model' => Artcoder\Ladmin\Entities\User::class,
  ],
],
```

```php
// config/app.php
  'providers' => [
    ...
    Artcoder\Ladmin\AdminServiceProvider::class,
  ],
```

```sh
# .env
  DB_DATABASE=xxx
  DB_USERNAME=xxx
  DB_PASSWORD=xxx
```

```sh
php artisan ladmin:setup
# php artisan module:make Cms
```

```php
// CmsController.php
  ...
  use use Artcoder\Ladmin\Http\Controllers\Controller as AdminController;
  ...
  class CmsController extends AdminController
```
