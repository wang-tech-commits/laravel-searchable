# laravel-searchable

## Requirement

 1. PHP >= 7.4
 2. laravel/framework >= 6.0|7.0|8.0
 
 ## Installing
 
 ```shell
 $ composer require wang-tech-commits/laravel-searchable -vvv
 ```

Optional, you can publish the config file:

```bash
$ php artisan vendor:publish --provider="MrwangTc\Searchable\ServiceProvider" --tag=config
```

And if you want to custom the migration of the versions table, you can publish the migration file to your database path:

```bash
$ php artisan vendor:publish --provider="MrwangTc\Searchable\ServiceProvider" --tag=migrations
```

> After you published the migration files, please update `'migrations' => false` in the config file `config/searchable.php` to disable load the package migrations. 

Then run this command to create a database migration:

```bash
$ php artisan migrate
```

## Usage

Add `MrwangTc\Searchable\Searchable` trait to the model and set searchable attributes:

```php
use MrwangTc\Searchable\Searchable;

class Article extends Model
{
    use Searchable;
    
    public static function boot() {
        parent::boot();
        
        static::saved(function($model) {
            // 文章关键字，可选参数；
            $keywords = ''; 
            $model->searchForModel($keywords);
        });
    }
    
    <...>
}
```

