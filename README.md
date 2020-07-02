<h2 align="center">
   <img src="https://raw.githubusercontent.com/LaraChimp/art-work/master/packages/mango-repo/mango-repo-art.png"> Mango Repo
</h2>

<p align="center">
    <a href="https://packagist.org/packages/larachimp/mango-repo"><img src="https://poser.pugx.org/larachimp/mango-repo/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/larachimp/mango-repo"><img src="https://poser.pugx.org/larachimp/mango-repo/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://travis-ci.org/LaraChimp/mango-repo"><img src="https://travis-ci.org/LaraChimp/mango-repo.svg?branch=master" alt="Build Status"></a>
    <a href="https://styleci.io/repos/84470262"><img src="https://styleci.io/repos/84470262/shield?branch=master" alt="StyleCI"></a>
    <a href="https://packagist.org/packages/larachimp/mango-repo"><img src="https://poser.pugx.org/larachimp/mango-repo/license" alt="License"></a>
    <a href="https://packagist.org/packages/larachimp/mango-repo"><img src="https://poser.pugx.org/larachimp/mango-repo/downloads" alt="Total Downloads"></a>
    <a href="https://insight.sensiolabs.com/projects/f21891ce-4b48-4507-aa4b-a25474571473" alt="medal"><img src="https://insight.sensiolabs.com/projects/f21891ce-4b48-4507-aa4b-a25474571473/mini.png"></a>
</p>

## Introduction
Mango Repo is an Eloquent Repository package that aims at bringing an easy to use and fluent API. Getting started with repository pattern can be 
quite overwhelming. This is especially true for newcomers to Eloquent who are getting the grasp of active record. Behind the scenes Mango Repo 
tries to use as much of the Eloquent API as possible and keeping things simple.

## License
Mango Repo is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Version Compatibility

 Laravel  | MangoRepo
:---------|:----------
 5.0.x    | 0.2.x
 5.1.x    | 0.2.x
 5.2.x    | 0.2.x
 5.3.x    | 0.2.x
 5.4.x    | 0.2.x
 5.5.x    | 0.2.x
 5.6.x    | 0.3.x
 5.7.x    | 0.3.x
 5.8.x    | 0.4.x
 6.x      | 1.x
 7.x      | 2.x
 
### Installation
Install Mango Repo as you would with any other dependency managed by Composer:

```bash
$ composer require larachimp/mango-repo
```

### Configuration
> If you are using Laravel >= 5.5, you can skip service registration 
> thanks to Laravel auto package discovery feature.

After installing Mango repo all you need is to register the ```LaraChimp\MangoRepo\MangoRepoServiceProvider``` and ```LaraChimp\PineAnnotations\PineAnnotationsServiceProvider``` 
in your `config/app.php` configuration file:

```php
'providers' => [
    // Other service providers...

    LaraChimp\PineAnnotations\PineAnnotationsServiceProvider::class,
    LaraChimp\MangoRepo\MangoRepoServiceProvider::class,
],
```

Optionally you can register the annotations reader alias.

```php
'aliases' => [
    ...
    'AnnotationsReader' => LaraChimp\PineAnnotations\Facades\Reader::class,
],
```

For more information check out the [PineAnnotations package](https://github.com/LaraChimp/pine-annotations) for more information on the annotation reader.

### Creating a repository class
Use the ```mango:make``` command to create your repository classes. This command will take as argument the repository class namesapce (from App) and 
a ```--model``` option which allows you to specify the full namespace of the Eloquent model to which the repository will be tied.

```bash
$ php artisan mango:make "Repositories\Posts" --model="App\Models\Post"
```

The above command will generate the following repository class in the ```app/Repositories``` directory:

```php
<?php

namespace App\Repositories;

use LaraChimp\MangoRepo\Repositories\EloquentRepository;

class Posts extends EloquentRepository
{
    /**
     * The target Eloquent Model.
     */
    const TARGET = \App\Models\Post::class;
}
```

Notice the ```const TARGET``` which specifies the Eloquent model the repository will make use of. If you would like to keep things a little bit
simpler, the ```mango:make``` command allows you to specify an optional ```--annotated``` option which generates a repository class that uses annotations
for specifying the Eloquent model:

```bash
$ php artisan mango:make "Repositories\Posts" --model="App\Models\Post" --annotated
```

The above command will generate the following repository class in the ```app/Repositories``` directory:

```php
<?php

namespace App\Repositories;

use LaraChimp\MangoRepo\Annotations\EloquentModel;
use LaraChimp\MangoRepo\Repositories\EloquentRepository;

/**
 * @EloquentModel(target="App\Models\Post")
 */
class Posts extends EloquentRepository
{
    //
}
```

### Using the repository
After creating your repository class, you may use it by resolving it via Laravel's Service container; either by dependency injection or by using the ```app()```
method.

In the following controller, we injected our ```Posts``` repository in the constructor and used it from our index method:

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\Posts;

class PostController extends Controller 
{
    /**
     * Posts repository instance.
     * 
     * @var Posts
     */
    protected $posts;
    
    public function __construct(Posts $posts) 
    {
        $this->posts = $posts;
    }
    
    public function index()
    {
        $allPosts = $this->posts->all();
        //
    }
}
```

> Take note that the repository class can be injected in not only controllers' constructors, but also methods and any service which is resolved by the service container.

You can also use the ```app()```, ```app()->make()``` or ```resolve()``` method to resolve an instance of your repository class and use it as you please:

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\Posts;

class PostController extends Controller 
{
    public function index()
    {
        $posts = app()->make(Posts::class)->all();
        //
    }
}
```

Although resolving repository classes from the service container seems the most efficient way to building up an instance, you may prefer to instantiate
your repository classes manually for some reasons. To achieve this call the ```boot()``` method on the new instance before using it.

The ```boot()``` method will take care of loading the repository class dependencies for us:

```php
$posts = (new \App\Repositories\Posts())->boot();
```

### Available Methods
Out of the box, repository classes comes with these methods already written for you. However, you are free to add your own methods or override 
existing methods in your repository class for building your own custom API and business logic.

To keep things as simple as possible, for many of theses methods, Mango Repo makes use of the same methods available on the Eloquent model.
Hence, Mango Repo's API tries to be as close to Eloquent's API as possible.

#### ```all()```
Get all of the models from the database: 

```php
$users = app(\App\Repositories\Users::class)->all();

// Illuminate\Database\Eloquent\Collection
```
or:
```php
$users = app(\App\Repositories\Users::class)->all(['name', 'email']);

// Illuminate\Database\Eloquent\Collection instance
```

#### ```paginate()```
Paginate the models from the database:

```php
$users = app(\App\Repositories\Users::class)->paginate(10, ['name', 'email']);

// Illuminate\Contracts\Pagination\LengthAwarePaginator instance
```

#### ```simplePaginate()```
Paginate the models from the database into a simple paginator:

```php
$users = app(\App\Repositories\Users::class)->simplePaginate(10, ['name', 'email']);

// Illuminate\Contracts\Pagination\Paginator
```

#### ```create()```
Save a new model and return the instance:

```php
$user = app(\App\Repositories\Users::class)->create([
            'name'     => 'John Doe', 
            'email'    => 'john@doe.com'
            'password' => Hash::make('secret')
         ]);
 
 // Illuminate\Database\Eloquent\Model
```

#### ```update()```
Update a model in the database. The update method accepts as its second argument
either the model instance or the model id:

```php
app(\App\Repositories\Users::class)->update(['name' => 'John Smith'], $userId);

// bool
```
or:
```php
app(App\Repositories\Users::class)->update(['name' => 'John Smith'], $user);

// bool
```

#### ```delete()```
Delete a record from the database.The delete method accepts as its first argument 
either the model instance or the model id:

```php
app(\App\Repositories\Users::class)->delete($userId);

// bool
```
or:
```php
app(\App\Repositories\Users::class)->delete($user);

// bool
```

#### ```find()```
Find a Model in the Database using the ID:

```php
app(\App\Repositories\Users::class)->find($userId);

// Illuminate\Database\Eloquent\Model
```
or:
```php
app(\App\Repositories\Users::class)->find($user_id, ['name', 'email']);

// Illuminate\Database\Eloquent\Model
```

#### ```findOrFail()```
Find a model in the database or throw an exception:

```php
app(\App\Repositories\Users::class)->findOrFail($userId);

// Illuminate\Database\Eloquent\Model
```
or:
```php
app(\App\Repositories\Users::class)->findOrFail($userId, ['name', 'email']);

// Illuminate\Database\Eloquent\Model
```

#### ```findBy()```
Find a model or models using some criteria:

```php
app(\App\Repositories\Users::class)->findBy(['last_name' => 'Doe']);

// Illuminate\Database\Eloquent\Collection
```
or:
```php
app(\App\Repositories\Users::class)->findBy(['last_name' => 'Doe'], ['last_name', 'email']);

// Illuminate\Database\Eloquent\Collection
```

#### ```getModel()```
Gets the Eloquent model instance:

```php
app(\App\Repositories\Users::class)->getModel();

// Illuminate\Database\Eloquent\Model
```

### Model Repository Scoping
Mango Repo do not make use of long and tedious "Criterias classes" for filtering queries, instead any repository class 
created using the ```mango:make``` command can be "Model Scoped". In simpler terms this only means that you may access 
[Local Query Scopes](https://laravel.com/docs/master/eloquent#local-scopes) defined on your models directly on the repository class.

Hence, you define your query scopes once on your model classes and use them directly on your repository classes for query filtering.

Consider the following example:

```php
<?php

namespace LaraChimp\MangoRepo\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
    //...
    
    /**
     * Apply an is active scope filter to the model.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
```

Since we've defined a local scope ```Active``` on our User Model, we don't have to rewrite the same scope twice within our
repository class. We simple use it directly on the repository class. Yes as simple as that!

```php
$activeUsers = app(\App\Repositories\Users::class)->active()->get();

// Illuminate\Database\Eloquent\Collection
```

You may even chain scopes and apply other filters as you would for any Eloquent model instance:

```php
 $users = app(\App\Repositories\Users::class)->popular()->active()->orderBy('created_at')->get();
 
 // Illuminate\Database\Eloquent\Collection
```

### Going Further
We think we've done a good job here at creating a simple but yet rich boilerplate for creating repository classes and in most cases
you would probably just create repository classes using the ```mango:make``` command like a breeze. However, if you still are not satisfied
and require creating your custom repository classes that do not need to be Model Scoped and so on; fear not we've got you covered.

First start by creating a class that implements ```LaraChimp\MangoRepo\Contracts\RepositoryInterface```. Now you may implement all the
methods available as you wish.

```php
<?php

namespace Acme\Company;

use LaraChimp\MangoRepo\Contracts\RepositoryInterface;

class MyCompanyRepo implements RepositoryInterface
{
    public function all($columns = ['*'])
    {
        // ...
    }
    
    // ...
}
```

Remember you do not need to implement these methods again, you may use the ```LaraChimp\MangoRepo\Concerns\IsRepositorable``` trait 
which already implements those method for you:

```php
<?php

namespace Acme\Company;

use LaraChimp\MangoRepo\Concerns\IsRepositorable;
use LaraChimp\MangoRepo\Contracts\RepositoryInterface;

class MyCompanyRepo implements RepositoryInterface
{
    use IsRepositorable;
    
    // ...
}
```

If you would like the repository to be bootable use the ```LaraChimp\MangoRepo\Concerns\IsRepositoryBootable``` trait, and for Model Scoping
use ```LaraChimp\MangoRepo\Concerns\IsRepositoryScopable``` :

```php
<?php

namespace Acme\Company;

use LaraChimp\MangoRepo\Concerns;
use LaraChimp\MangoRepo\Contracts\RepositoryInterface;

class MyCompanyRepo implements RepositoryInterface
{
    use Concerns\IsRepositorable,
        Concerns\IsRepositoryBootable,
        Concerns\IsRepositoryScopable;
    
    // ...
}
```

### Credits
Big Thanks to all developers who worked hard to create something amazing!

[![LaraChimp](https://img.shields.io/badge/Author-LaraChimp-blue.svg?style=flat-square)](https://github.com/LaraChimp)

#### Creator
Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)

GitHub: [percymamedy](https://github.com/percymamedy)
