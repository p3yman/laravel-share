# Laravel Share
Laravel Share is an easy way to share any data through a request. 

## Introduction
With Laravel Share you can share any data through a request to use later. You should consider it as an array that are available everywhere. I mean EVERYWHERE! From Service Provider to routes, middlewares, controllers and views.

## Installation
#### Install using [Composer](https://getcomposer.org/doc/00-intro.md)
```
$ composer require peyman3d/laravel-share
```
When installation completes you should add provider and alias to `config/app.php` file. If you are using Laravel 5.5 or 5.6 you can skip this step as Laravel can discover this package automatically.

- Add to providers array:
```php
Peyman3d\Share::class,
```
- Add to alias array:
```php
'Share' => Peyman3d\Share\ShareFacade::class,
```

## Usage
Using Laravel Share is easy as pie. Just think of a person and you can share data like this:
```php
Share::make('Person')
	   ->add('name', 'Peyman')
	   ->add('email', 'salam@peyman.me')
	   ->add('job', 'Web developer')
	   ->edit('title', 'Mr');
```
As you see you can create an item with `make()` method. then you can add parameters to it by using `add($key, $value)` or `edit($key, $value)`. You can also use `share()` helper instead of `Share` Facade.
```php
share()->make('asset.js')->add('react', 'https://cdnjs.cloudflare.com/ajax/libs/react/16.4.0/umd/react.production.min.js')
```

There are some basic methods for working with data array:
```php
// Change key
share()->key('menu');

// Make new item with key and value
share()->make($key, $value, $single);

// Create new item to current key
share()->make('menu')->item('dashboard');

// Prepend an item to current key
share()->make('menu')->prepend('posts');

// Add a child to array
share()->make('menu')->item('users')->child('users-list');

// Check if key exists
share()->key('menu')->has('dashboard');

// Get from array with key
// Second parameter is for get result as single value or collection
share()->key('menu')->get('users', true);

// Pull data from array and delete it
share()->key('menu')->pull('users', true);

// Get all data
share()->all();

// Delete data for current key
share()->key('menu.users')->delete();

// Delete all data
share()->reset();

```

## Even better helpers
Laravel Share has more helpers to create better syntax. You can use any combination of these helpers.
```php
share()->make('Job')->title('Senior Developer');
```
As you can see `title()` method accept a value and work just like `add('title', 'Senior Developer')`.

Check all helpers here:
- `id()`
- `title()`
- `subtitle()`
- `label()`
- `icon()`
- `link()`
- `route()`
- `route_attributes()`
- `href()`
- `fallback()`
- `callback()`
- `order()`
- `class()`
- `desc()`
- `type()`
- `default()`
- `options()`
- `name()`
- `placeholder()`
- `children()`
- `file()`
- `src()`
- `active()`
- `config()`
- `format()`
- `permission()`
- `count()`
- `attributes()`
- `field()`
- `blade()`

Other than this helpers for parameters, we also have some helpers for sections and types:

- `menu()` 
- `view()` 
- `asset()` 
- `js()` 
- `css()` 
- `script()` 
- `style()` 

You can check some examples:
```php
// Create new menu with items
share()->menu()->item('dashboard')->label('Dashboard')->href('/admin/');
share()->menu()->item('users')->label('Users')->route('admin.users');
share()->menu('users')->child('users-profile')->label('Profile')->route('admin.users.profile');
share()->menu('users')->child('users-list')->label('All users')->route('admin.users.index');
share()->menu('users')->child('users-create')->label('Add new user')->route('admin.users.create');

// Manage Assets
share()->js('jquery')->link('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js')->order(500);
share()->js('react')->link('https://cdnjs.cloudflare.com/ajax/libs/react/16.4.0/umd/react.production.min.js')->order(300);
```