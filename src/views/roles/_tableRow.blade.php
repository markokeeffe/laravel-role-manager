<?php
/**
 * Author:  Mark O'Keeffe

 * Date:    30/08/13
 *
 * [Laravel - Vanilla] _tableRow.php
 */
?>
<tr>
  <td>{{{ $role->name }}}</td>
  <td>{{{ $role->permissionsCount }}}</td>
  <td class="controls">

    {{ Form::open(array('method' => 'DELETE',
    'action' => array('MOK\RoleManager\RoleController@destroy', $role->id),
    'class' => 'form-inline pull-right',
    )) }}
    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
    {{ Form::close() }}

    {{ link_to_action('MOK\RoleManager\RoleController@edit',
    'Edit', array($role->id), array(
    'class' => 'btn btn-xs btn-info pull-right',
    )) }}

    {{ link_to_action('MOK\RoleManager\RoleController@permissions',
    'Permissions', array($role->id), array(
    'class' => 'btn btn-xs btn-success pull-right',
    )) }}
  </td>
</tr>
