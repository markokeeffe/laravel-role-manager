@if (!count($permissions))
  <p>No new routes found.</p>
@else
  {{ Form::open(array(
    'action' => 'MOK\RoleManager\PermissionController@autoUpdate',

  )) }}

    <p>{{ count($permissions) }} new routes found:</p>

    <table class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>Route</th>
        <th>Name</th>
        <th>Save?</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($permissions as $i => $permission)
      <tr>
        <td>{{{ $permission->name }}}</td>
        <td>{{{ $permission->display_name }}}</td>
        <td>
          <input type="checkbox" name="perms[{{ $i }}]" checked="checked" value="1"/>
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>

    <button type="submit" class="btn btn-success">Save</button>

  {{ Form::close() }}
@endif
