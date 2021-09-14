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
      ...
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
```

# Modules & Repository

```sh
php artisan module:make Cms
```

```php
// CmsController.php
  ...
  use use Artcoder\Ladmin\Http\Controllers\Controller as AdminController;
  ...
  class CmsController extends AdminController {
	...
	public $moduleName = 'cms';
	...
	
// Model
	use Artcoder\Ladmin\Entities\Model;

	class FarmingAccount extends Model
// Repositories
namespace Modules\Cms\Repositories;

use Modules\Cms\Entities\Posts;
use Artcoder\Ladmin\Repositories\BaseRepository;

class PostsRepository extends BaseRepository
{
    public function model()
    {
        return Posts::class;
    }
}
// view
$folder       = 'cms-posts';
$title           = '文章列表';
$targetUrl   = route('admin.cms.create');
$targetTitle = '添加文章';
$list            = $this->posts->all();
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



