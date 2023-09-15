# Installation

```sh
# composer 镜像  https://pkg.xyz/
composer create-project laravel/laravel=8.* test
composer create-project laravel/laravel demo
cd demo
composer require artcoder/ladmin
```

```json
// composer.json
{
  "autoload": {
    "psr-4": {
      // ...
      "Modules\\": "Modules/"
    }
  }
}
```

```sh
mkdir Modules
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
// app/Http/Middleware/EncryptCookies.php
protected $except = [
  'hints'
];
```

```php
// config/app.php
'providers' => [
  // ...
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
...
#for update
#del admin.php & status.php
#php artisan vendor:publish --provider="Artcoder\Ladmin\AdminServiceProvider"
```

# Modules & Repository

```sh
php artisan module:make Cms
```

```php
// CmsController.php
  // ...
  use use Artcoder\Ladmin\Http\Controllers\Controller as AdminController;
  // ...
  class CmsController extends AdminController {
	// ...
	public $moduleName = 'cms';
	// ...
	
// Model
	use Artcoder\Ladmin\Entities\Model;

	class FarmingAccount extends Model

// Repositories
  namespace Modules\Cms\Repositories;

  use Modules\Cms\Entities\Posts;
  use Artcoder\Ladmin\Repositories\BaseRepository;
  // or use Artcoder\Ladmin\Repositories\AdminRepository;

  class PostsRepository extends BaseRepository
  {
    // ...
    // ->model('category', 'cms')  // model
    // ->repository('category', 'cms') // repository
  }
// view
  $folder      = 'cms-posts';
  $title       = '文章列表';
  $targetUrl   = route('admin.cms.create');
  $targetTitle = '添加文章';
  $list        = $this->posts->all();
  return view(
      'cms::' . $folder . '.index',
    compact('folder', 'list', 'title', 'targetUrl', 'targetTitle')
  );

  return view(
    'admin::partials.create',
      compact('folder', 'title', 'targetUrl', 'targetTitle', 'model', 'formUrl')
  );

  return view(
    'admin::partials.edit',
      compact('id', 'folder', 'title', 'targetUrl', 'targetTitle', 'model', 'formUrl')
  );
```

```php
// Traits
  // Artcoder\Ladmin\Libraries\Support\Traits\HasConfig
    // #cacheKey
    // @getItem($index, $defalt = false)
    // @clearCache()
    // @getList()
  // Artcoder\Ladmin\Libraries\Support\Traits\HasConfigRepository
    // @info($index = '')
    // @pluckInfo()
    // @clearCache()
  // Artcoder\Ladmin\Libraries\Support\Traits\HasStatus
    // #
  // Artcoder\Ladmin\Libraries\Support\Traits\HasStoreAuth
  // Artcoder\Ladmin\Libraries\Support\Traits\HasTree
  // Artcoder\Ladmin\Libraries\Support\Traits\HasTreeRepository
  // Artcoder\Ladmin\Libraries\Support\Traits\HasUnableDeletePK
    // #unableIdValue [1, 2...]
    // @canDeletePK()
```


