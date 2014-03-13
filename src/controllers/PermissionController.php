<?php namespace MOK\RoleManager;

use Response;
use View;
use Input;
use Validator;
use Redirect;

class PermissionController extends BaseController {

	/**
	 * Permission Repository
	 *
	 * @var Permission
	 */
	protected $permission;

	public function __construct(Permission $permission)
	{
		$this->permission = $permission;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = $this->permission->all();
		return View::make('RoleManager::permissions.index', compact('permissions'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('RoleManager::permissions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Permission::$rules);

		if ($validation->passes())
		{
			$this->permission->create($input);

			return Redirect::action('MOK\RoleManager\PermissionController@index');
		}

		return Redirect::action('MOK\RoleManager\PermissionController@create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$permission = $this->permission->findOrFail($id);

		return View::make('RoleManager::permissions.show', compact('permission'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$permission = $this->permission->find($id);

		if (is_null($permission))
		{
			return Redirect::action('MOK\RoleManager\PermissionController@index');
		}

		return View::make('RoleManager::permissions.edit', compact('permission'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, Permission::$rules);

		if ($validation->passes())
		{
			$permission = $this->permission->find($id);
			$permission->update($input);

			return Redirect::action('MOK\RoleManager\PermissionController@show', $id);
		}

		return Redirect::action('MOK\RoleManager\PermissionController@edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->permission->find($id)->delete();

		return Redirect::action('MOK\RoleManager\PermissionController@index');
	}

  /**
   * Search for routes that have not been saved as permissions.
   * Once the user has confirmed; save the selected routes as new permissions.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function autoUpdate()
  {
    $permissions = $this->permission->findFromRoutes();

    if ($checked = Input::get('perms')) {

      $count = 0;
      foreach ($checked as $i => $check) {
        if ($check && $permissions[$i]->save()) {
          $count++;
        }
      }

      return Redirect::action('MOK\RoleManager\PermissionController@index')
        ->with('message', $count.' permissions added.');

    } else {
      $body = View::make('RoleManager::permissions._autoUpdate',
        compact('permissions')
      )->render();
    }

    $modal = array(
      'heading' => 'Auto-Update Permissions',
      'body' => $body,
    );

    return Response::modal($modal);
  }

}
