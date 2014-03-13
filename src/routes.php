<?php
/**
 * Author:  Mark O'Keeffe

 * Date:    29/08/13
 *
 * [Laravel - Vanilla] routes.php
 */
// Get the handles config item
$handle = Config::get('RoleManager::handle');

Route::group(array('prefix' => $handle, 'before' => 'auth|auth.roleManager'), function(){
  Route::any('/', function(){
    return Redirect::action('MOK\RoleManager\UserController@index');
  });

  Route::any('users/{id}/roles', 'MOK\RoleManager\UserController@roles');
  Route::any('users/{id}/roles/add_all', 'MOK\RoleManager\UserController@addAllRoles');
  Route::any('users/{id}/roles/detach_all', 'MOK\RoleManager\UserController@detachAllRoles');
  Route::any('users/{id}/roles/{role_id}/add', 'MOK\RoleManager\UserController@addRole');
  Route::any('users/{id}/roles/{role_id}/detach', 'MOK\RoleManager\UserController@detachRole');
  Route::get('users', 'MOK\RoleManager\UserController@index');

  Route::any('roles/{id}/permissions', 'MOK\RoleManager\RoleController@permissions');
  Route::any('roles/{id}/permissions/add_all', 'MOK\RoleManager\RoleController@addAllPermissions');
  Route::any('roles/{id}/permissions/detach_all', 'MOK\RoleManager\RoleController@detachAllPermissions');
  Route::any('roles/{id}/permissions/{permission_id}/add', 'MOK\RoleManager\RoleController@addPermission');
  Route::any('roles/{id}/permissions/{permission_id}/detach', 'MOK\RoleManager\RoleController@detachPermission');
  Route::any('roles/{id}/permissions/{group}/addgroup', 'MOK\RoleManager\RoleController@addPermissionGroup');
  Route::any('roles/{id}/permissions/{group}/detachgroup', 'MOK\RoleManager\RoleController@detachPermissionGroup');
  Route::resource('roles', 'MOK\RoleManager\RoleController');

  Route::any('permissions/autoupdate', 'MOK\RoleManager\PermissionController@autoUpdate');
  Route::resource('permissions', 'MOK\RoleManager\PermissionController');


});
