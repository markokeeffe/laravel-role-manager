<?php namespace MOK\RoleManager;
/**
 * Author:  Mark O'Keeffe

 *
 * Date:    29/08/13
 *
 * [Laravel - Vanilla] Permission.php
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
use Zizaco\Entrust\EntrustPermission;
use Route;

class Permission extends EntrustPermission
{
  protected $fillable = array('name', 'display_name');
  protected $with = array('roles');

  /**
   * Ardent validation rules
   *
   * @var array
   */
  public static $rules = array(
    'name' => 'required|between:4,255',
    'display_name' => 'required|between:4,255'
  );

  /**
   * Many-to-Many relations with Permission
   * named perms as permissions is already taken.
   */
  public function roles()
  {
    return $this->belongsToMany('Role');
  }

  /**
   * Scope to find all permissions not assigned to a particular role
   *
   * @param $query
   * @param $role
   *
   * @return mixed
   */
  public function scopeNotInRole($query, $role)
  {
    // Get all available permissions not associated with the role
    if (count($role->perms->modelKeys())) {
      return $query->whereNotIn('id', $role->perms->modelKeys());
    }
    return $query;
  }

  /**
   * Get the name of the controller for the current permission
   *
   * @return mixed
   */
  public function getGroupNameAttribute()
  {
    $parts = explode(' - ', $this->display_name);
    if (count($parts) == 2) {
      return $parts[0];
    }
    return null;
  }

  /**
   * Get an array of permission model instances grouped by controller name
   *
   * @param      $role
   * @param bool $associated Are the permissions associated with the role?
   *
   * @return array
   */
  public function getGrouped($role, $associated=true)
  {

    if ($associated) {
      $perms = $role->perms()->orderBy('name')->get();
    } else {
      $perms = $this->notInRole($role)->orderBy('name')->get();
    }

    $groups = array();

    foreach ($perms as $perm) {
      $name = ($perm->groupName ? $perm->groupName : 'No Group');
      if (!isset($groups[$name])) {
        $groups[$name] = array();
      }
      $groups[$name][] = $perm;
    }

    return $groups;

  }

  /**
   * Find new permissions from the application's routes
   */
  public function findFromRoutes()
  {
    $permissions = array();
    // All Routes
    foreach (Route::getRoutes()->all() as $route) {
      if (!$action = $route->getAction()) {
        continue;
      }
      if (strstr($action, 'MOK\RoleManager')) {
        continue;
      }
      if (!$permission = $this->where('name', '=', $action)->first()) {
        $attrs = array(
          'name' => $action,
          'display_name' => $this->getDisplayName($action),
        );
        $permissions[] = new Permission($attrs);
      }
    }

    return $permissions;
  }

  /**
   * Create a display name for a controller action from the route's action name
   *
   * @param $action
   *
   * @return string
   */
  public function getDisplayName($action)
  {
    $parts = explode('@', $action);
    if (count($parts) == 2) {
      $object = str_replace('Controller', '', $parts[0]);
      $action = studly_case($parts[1]);
      return ucfirst($object).' - '.$action;
    }
    return implode('', $parts);
  }
}
