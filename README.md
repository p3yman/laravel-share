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
And when you want that data just use `Share::get('Person');`;

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

## What data can be shared?
Almost anything. You can share any string, numbers, objects and closures.
```php
share()->make('user')->add('profile', auth()->user());
share()->menu('posts')->add('filter', function($value){
    return '<h3>'.$value.'</h3>';   
});
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

### Custom helpers
I added some basic helpers that works for me, but you can also add yours. You can remove or edit items too. See some examples below:
```php
// Arguments
share()->addArg('avatar');
share()->removeArg('icon');
share()->editArg('subtitle', 'second-title');
if( share()->hasArg('config') ){
    share()->editArg('config', 'setting');
}

// Keys
share()->addKey('table');
share()->removeKey('view');
share()->editKey('asset', 'libraries');
if( share()->hasKey('menu') ){
    share()->editKey('menu', 'menus');
}
```


## Just an example
Imagine you have an admin panel that has a menu on sidebar. This menu has multiple items and each one may have sub-items.
Now, we add some items to the menu:
```php
// Add dashboard
share()->menu()->item('dashboard')->label('Dashboard')->icon('fa fa-dashboard')->route('admin.dashboard');

// Add posts and it's sub items
share()->menu()->item('posts')->label('Posts')
               ->icon('fa fa-file-text-o')->route('admin.posts');
share()->menu('posts')->child('posts-list')->label('All posts')
                      ->route('admin.posts.index');
share()->menu('posts')->child('posts-create')->label('Add new post')
                      ->route('admin.posts.create');

// Add setting
share()->menu()->item('settings')->label('Settings')->icon('fa fa-cogs');
foreach($setting_pages as $page){
    share()->menu('settings')->child('setting-page-'.$page['id'])->label($page['label'])
                          ->route('admin.settings')
                          ->route_attributes(['slug'=>$page['slug']]);
}
```
These codes can be anywhere: Service Provider, routes, middlewares, controller, model and even a blade view.
If you want you can active a menu item like this:
```php
// PostController.php

public function index(){
    share()->key('menu.posts')->activate();
    share()->key('menu.posts.children.posts-list')->activate();
}
```
And you can sort items with `order()` method. It can be done when you add an item or just any other times and places.
```php
// AdminMiddleware.php

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        share()->key('menu.posts')->order(100);
    
	    return $next($request);
    }
}
```
If you don't set order, it counts as 100.

And finally you can use this data in a blade view like `sidebar.blade.php` as simple as this:
```blade
<aside id="sidebar">

    <ul class="menu">
    
        @foreach( share()->menu()->get() as $item )
        
            <li class="menu-item @if( array_has($item, 'children') ) has-child @endif @if(array_get($menu_item, 'active', false)) active @endif">
            
                <a href="{{ make_menu_link($item) }}">
                    <i class="{{ array_get($item, 'icon') }}"></i>
                    <span class="title">{{ array_get($item, 'label') }}</span>
                </a>

                @if( array_has($item, 'children') )
                    <ul class="sub-menu" @if(array_get($menu_item, 'active', false)) style="display: block;" @endif>
                        @foreach( $item['children'] as $subitem )
                            <li><a href="{{ make_menu_link($subitem) }}">{{ $subitem['label'] }}</a></li>
                        @endforeach
                    </ul>
                @endif

            </li>
        
        @endforeach
    
    </ul>

</aside>
```
And that's just it :)
Just one thing. I use a helper function called `make_menu_link()` that I wrote for create item link base on what it has. It's not on the package as it may not be useful for you. But you can have it in this [link](https://gist.github.com/peyman3d/97941c94d4b877b4a76075fbc3dce122).