<?php
/**
 * Author:  Mark O'Keeffe

 * Date:    29/08/13
 *
 * [Laravel - Vanilla] filters.php
 */

// The authentication
Route::filter('auth.roleManager', function()
{
  if (!Auth::user()->hasRole('Superuser')) return Redirect::guest('user/login');
});

View::composer('RoleManager::layouts.main', function($view){

  // Get the handles config item
  $handle = Config::get('RoleManager::handle');

  $menu = array(
    array(
      'link' => $handle.'/users',
      'title' => 'Users',
    ),
    array(
      'link' => $handle.'/roles',
      'title' => 'Roles',
    ),
    array(
      'link' => $handle.'/permissions',
      'title' => 'Permissions',
    ),
    array(
      'link' => $handle.'/permissions/autoupdate',
      'title' => 'Auto-Update Permissions',
      'options' => array(
        'data-behavior' => 'ajaxLink',
      ),
    ),
  );

  $view->with('menu', $menu);
});
