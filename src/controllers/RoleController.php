<?php namespace MOK\RoleManager;

use App;
use View;
use Input;
use Validator;
use Redirect;

class RoleController extends BaseController {

	/**
	 * Permission Repository
	 *
	 * @var Permission
	 */
	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Response
	 */
	public function index()
	{
		$roles = $this->role->all();
		return View::make('RoleManager::roles.index', compact('roles'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Response
	 */
	public function create()
	{
		return View::make('RoleManager::roles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return \Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Role::$rules);

		if ($validation->passes())
		{
			$this->role->create($input);

			return Redirect::action('MOK\RoleManager\RoleController@index');
		}

		return Redirect::action('MOK\RoleManager\RoleController@create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Response
	 */
	public function show($id)
	{
		$role = $this->role->findOrFail($id);

		return View::make('RoleManager::roles.show', compact('role'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Response
	 */
	public function edit($id)
	{
		$role = $this->role->find($id);

		if (is_null($role))
		{
			return Redirect::action('MOK\RoleManager\RoleController@index');
		}

		return View::make('RoleManager::roles.edit', compact('role'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return \Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Role::$rules);

		if ($validation->passes())
		{
			$role = $this->role->find($id);
			$role->update($input);

			return Redirect::action('MOK\RoleManager\RoleController@show', $id);
		}

		return Redirect::action('MOK\RoleManager\RoleController@edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Response
	 */
	public function destroy($id)
	{
		$this->role->find($id)->delete();

		return Redirect::action('MOK\RoleManager\RoleController@index');
	}

  /**
   * Manage permissions within a role
   *
   * @param $id
   *
   * @return \Response
   */
  public function permissions($id)
  {
    // Get the role
    $role = $this->role->find($id);
    $permission = new Permission;

    return View::make('RoleManager::roles.permissions', compact('role', 'permission'));
  }

  /**
   * Add all available permissions to a role
   *
   * @param $id
   *
   * @return \Response
   */
  public function addAllPermissions($id)
  {
    return $this->handleAllPermissions('add', $id);
  }

  /**
   * Remove all permissions from a role
   *
   * @param $id
   *
   * @return \Response
   */
  public function detachAllPermissions($id)
  {
    return $this->handleAllPermissions('detach', $id);
  }

  /**
   * Add a permission to the current role
   *
   * @param $id
   * @param $permission_id
   *
   * @return \Response
   */
  public function addPermission($id, $permission_id)
  {
    return $this->handlePermission('add', $id, $permission_id);
  }

  /**
   * Remove a permission from the current role
   *
   * @param $id
   * @param $permission_id
   *
   * @return \Response
   */
  public function detachPermission($id, $permission_id)
  {
    return $this->handlePermission('detach', $id, $permission_id);
  }

  /**
   * Add a group of permissions to this role
   *
   * @param $id
   * @param $group
   *
   * @return \Response
   */
  public function addPermissionGroup($id, $group)
  {
    return $this->handlePermissionGroup('add', $id, $group);
  }

  /**
   * Remove a group of permissions from this role
   *
   * @param $id
   * @param $group
   *
   * @return \Response
   */
  public function detachPermissionGroup($id, $group)
  {
    return $this->handlePermissionGroup('detach', $id, $group);
  }

  /**
   * Handle adding or removing a permission for this role
   *
   * @param $action
   * @param $id
   * @param $permission_id
   * @return \Response
   */
  private function handlePermission($action, $id, $permission_id)
  {
    // Get the role
    $role = $this->role->findOrFail($id);
    if ($action == 'add') {
      $role->perms()->attach($permission_id);
    } else {
      $role->perms()->detach($permission_id);
    }

    return Redirect::action('MOK\RoleManager\RoleController@permissions', array(
      'id' => $id,
    ));

  }

  /**
   * Handle adding or detaching grouped permissions for this role
   *
   * @param $action
   * @param $id
   * @param $group
   * @return \Response
   */
  private function handlePermissionGroup($action, $id, $group)
  {
    // Get the role
    $role = $this->role->findOrFail($id);
    $permission = new Permission;

    if ($action == 'add') {
      // Get grouped permissions not in this role
      $groups = $permission->getGrouped($role, false);
    } else {
      // Get grouped permissions in this role
      $groups = $permission->getGrouped($role, true);
    }

    if (!isset($groups[$group])) {
      App::abort(404, 'Group not found.');
    }

    foreach ($groups[$group] as $permission) {
      if ($action == 'add') {
        $role->perms()->attach($permission->id);
      } else {
        $role->perms()->detach($permission->id);
      }
    }

    return Redirect::action('MOK\RoleManager\RoleController@permissions', array(
      'id' => $id,
    ));
  }

  /**
   * Handle adding or removing all permissions for this role
   *
   * @param $action
   * @param $id
   *
   * @return \Response
   */
  private function handleAllPermissions($action, $id)
  {
    // Get the role
    $role = $this->role->findOrFail($id);

    if ($action == 'add') {
      // Get available permissions
      $permissions = Permission::notInRole($role)->get();
      foreach ($permissions as $permission) {
        $role->perms()->attach($permission->id);
      }
    } else {
      $role->perms()->sync(array());
    }

    return Redirect::action('MOK\RoleManager\RoleController@permissions', array(
      'id' => $id,
    ));
  }
}
