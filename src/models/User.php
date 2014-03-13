<?php namespace MOK\RoleManager;

use Zizaco\Confide\ConfideUser;
use Zizaco\Entrust\HasRole;

/**
 * An Eloquent Model: 'User'
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $confirmation_code
 * @property boolean $confirmed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Role[] $roles
 */
class User extends ConfideUser {
  use HasRole;

  protected $with = array('roles');

  /**
   * Get a pipe separated list of roles for the user
   *
   * @return string
   */
  public function getRolesListAttribute()
  {
    $list = array();
    foreach ($this->roles as $role) {
      $list[] = $role->name;
    }
    return implode(' | ', $list);
  }

}
