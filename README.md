# composer create-project laravel/laravel example-app
# cd example-app
# composer require artcoder/ladmin

composer.json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "modules/"
    }
  }
}
# mkdir modules
# composer dump-autoload

config/auth.php
'providers' => [
  'users' => [
    'driver' => 'eloquent',
    'model' => Artcoder\Ladmin\Entities\User::class,
  ],
],

config/app.php
  'providers' => [
    ...

  ],

.env
  DB_DATABASE=xxx
  DB_USERNAME=xxx
  DB_PASSWORD=xxx

# php artisan ladmin:setup
