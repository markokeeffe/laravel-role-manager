@extends('RoleManager::layouts.main')

@section('title', 'Edit Role')

@section('main')

{{ Form::model($role, array('method' => 'PATCH',
  'action' => array('MOK\RoleManager\RoleController@update', $role->id),
  'class' => 'form-horizontal col-lg-6 col-lg-offset-3',
)) }}

  @include('RoleManager::roles._form')

  <div class="form-group">
    <div class="col-lg-8 col-lg-offset-4">
      <button type="submit" class="btn btn-info">Update</button>
      {{ link_to_action('MOK\RoleManager\RoleController@show',
        'Cancel', $role->id, array(
          'class' => 'btn btn-default',
        )
      ) }}
    </div>
  </div>

{{ Form::close() }}

@stop
