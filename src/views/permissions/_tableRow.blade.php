<?php
/**
 * Author:  Mark O'Keeffe

 * Date:    30/08/13
 *
 * [Laravel - Vanilla] _tableRow.php
 */
?>
<tr>
  <td>{{{ $permission->name }}}</td>
  <td>{{{ $permission->display_name }}}</td>

  <td class="controls">

    {{ Form::open(array('method' => 'DELETE',
    'action' => array('MOK\RoleManager\PermissionController@destroy', $permission->id),
    'class' => 'form-inline pull-right',
    )) }}
    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
    {{ Form::close() }}

    {{ link_to_action('MOK\RoleManager\PermissionController@edit',
    'Edit', array($permission->id), array(
    'class' => 'btn btn-xs btn-info pull-right',
    )
    ) }}
  </td>
</tr>
