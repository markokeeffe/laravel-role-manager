<?php namespace MOK\RoleManager;

use Response;
use View;
use Redirect;

/**
 * Author:  Mark O'Keeffe

 * Date:    30/08/13
 *
 * [Laravel - Vanilla] UserController.php
 */
class UserController extends BaseController {

  /**
   * Permission Repository
   *
   * @var User
   */
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $users = $this->user->all();
    return View::make('RoleManager::users.index', compact('users'));
  }

  /**
   * Manage roles associated with the current user
   *
   * @param $id
   *
   * @return \Illuminate\View\View
   */
  public function roles($id)
  {
    $user = $this->user->findOrFail($id);
    $role = new Role;
    return View::make('RoleManager::users.roles', compact('user', 'role'));
  }

  /**
   * Add all available roles to a user
   *
   * @param $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function addAllRoles($id)
  {
    return $this->handleAllRoles('add', $id);
  }

  /**
   * Remove all roles from a user
   *
   * @param $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function detachAllRoles($id)
  {
    return $this->handleAllRoles('detach', $id);
  }

  /**
   * Add a role to the current user
   *
   * @param $id
   * @param $role_id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function addRole($id, $role_id)
  {
    return $this->handleRole('add', $id, $role_id);
  }

  /**
   * Remove a role from the current user
   *
   * @param $id
   * @param $role_id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function detachRole($id, $role_id)
  {
    return $this->handleRole('detach', $id, $role_id);
  }

  /**
   * Handle adding or removing a role for this user
   *
   * @param $action
   * @param $id
   * @param $role_id
   * @return \Illuminate\Http\RedirectResponse
   */
  private function handleRole($action, $id, $role_id)
  {
    // Get the role
    $user = $this->user->findOrFail($id);
    if ($action == 'add') {
      $user->roles()->attach($role_id);
    } else {
      $user->roles()->detach($role_id);
    }

    return Redirect::action('MOK\RoleManager\UserController@roles', array(
      'id' => $id,
    ));

  }

  /**
   * Handle adding or removing all roles for this role
   *
   * @param $action
   * @param $id
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  private function handleAllRoles($action, $id)
  {
    // Get the role
    $user = $this->user->findOrFail($id);

    if ($action == 'add') {
      // Get available roles
      $roles = Role::notInUser($user)->get();
      foreach ($roles as $role) {
        $user->roles()->attach($role->id);
      }
    } else {
      $user->roles()->sync(array());
    }

    return Redirect::action('MOK\RoleManager\UserController@roles', array(
      'id' => $id,
    ));
  }

}
