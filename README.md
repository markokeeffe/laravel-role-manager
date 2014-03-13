laravel-role-manager
====================

Interface for managing user roles and permissions based on <a href="https://github.com/Zizaco/entrust" target="_blank">Zizaco/Entrust</a> authorisation system.

## Prerequisites ##

Before you can use the role manager, you must install and configure <a href="https://github.com/Zizaco/entrust" target="_blank">Zizaco/Entrust</a> according to the documentation.

You must set up at least one user that you are able to log in with before you can start using the role manager.

## Installation ##

Add the following to the `require` object in your `composer.json`:

```json
  "require": {
    "laravel/framework": "4.0.*",
    "markokeeffe/role-manager": "dev-trunk"
  },
```

Update composer:

```bash
$ composer update
```

Add the Role Manager service provider in `config/app.php`:

```php
'providers' => array(
    ...
    'MOK\RoleManager\RoleManagerServiceProvider',
),
```

## Initialisation ##

Before the Role Manager can be initialised, there must be one user saved in the
database that you want to declare the 'Superuser'. Only users with the Superuser
role will be able to use the Role Manager.

To set up the Superuser role and assign it to your user account:

-  Find the ID of your user account e.g. 2
-  Execute the Role Manager initialise command using the user ID:

```bash
$ php artisan rolemanager:init --user_id=2
```

The Role Manager should now be accessible to the selected user when they are
logged in.

## Configuration ##

The default URL path to the role manager is `/rolemanager`. If you want to change this
value, publish the config file to your config directory:

```bash
$ php artisan config:publish markokeeffe/role-manager
```

You can now change the value in `config/packages/markokeeffe/role-manager/config.php`:

```php
return array(
  'handle' => 'my_role_manager'
);
```

## Implementing Role Based Authentication ##

In your `filters.php` file:

```php
// Check the current user has permission to access the current route action
Route::filter('auth.permission', function()
{
  // Get the permission name from the current route action
  $permission = Route::getCurrentRoute()->getAction();
  if (!Entrust::can($permission))
  {
    return Redirect::to('/');
  }
});
```

In your `routes.php` file:

```php
Route::group(array('before' => 'auth|auth.permission'), function(){

  // Your routes here e.g.
  Route::get( 'user/create',                 'UserController@create');
  //...

});
```

## Usage ##

 - Go to the URL path you have configured (default `/rolemanager`) e.g. `http://myapp.dev/rolemanager`.

 - Click 'Auto-Update Permissions' to generate permissions based on all controller
actions in your project.

 - Go to the 'Roles' section and create a new role e.g. 'Administrator'.

 - Find your newly created role in the table and click the 'Permissions' button.

 - Add the desired permissions for this role from the table on the left.

 - To assign a role to a user, go to 'Users', find the user you wish to manage,
 click the 'Roles' button and add roles to the user from the table on the left.
