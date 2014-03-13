<?php namespace MOK\RoleManager;
/**
 * Author:  Mark O'Keeffe

 *
 * Date:    29/08/13
 *
 * [Laravel - Vanilla] Role.php
 *
 * @property integer $id
 * @property string $name
 * @property string $permissions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $users
 * @property-read \MOK\RoleManager\Permission[] $perms
 */
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
  protected $fillable = array('name');
  protected $with = array('perms');

  /**
   * Many-to-Many relations with Permission
   * named perms as permissions is already taken.
   */
  public function perms()
  {
    return $this->belongsToMany('MOK\RoleManager\Permission')->orderBy('name');
  }

  /**
   * Scope to find all roles not assigned to a particular user
   *
   * @param $query
   * @param $user
   *
   * @return mixed
   */
  public function scopeNotInUser($query, $user)
  {
    // Get all available permissions not associated with the role
    if (count($user->roles->modelKeys())) {
      return $query->whereNotIn('id', $user->roles->modelKeys());
    }
    return $query;
  }

  /**
   * Get the number of permissions this role has
   *
   * @return int
   */
  public function getPermissionsCountAttribute()
  {
    return count($this->perms);
  }

  /**
   * Get all roles either associated with a user, or not associated with user
   *
   * @param      $user
   * @param bool $associated Are the roles associated to the user?
   *
   * @return array
   */
  public function getForUser($user, $associated=true)
  {
    if ($associated) {
      return $user->roles()->orderBy('name')->get();
    } else {
      return $this->notInUser($user)->orderBy('name')->get();
    }
  }
}
