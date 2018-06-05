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

