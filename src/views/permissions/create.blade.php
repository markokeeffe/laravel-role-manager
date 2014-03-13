@extends('RoleManager::layouts.main')

@section('title', 'Create Permission')

@section('main')

<p>
  {{ link_to_action('MOK\RoleManager\PermissionController@index',
    'All permissions', array(), array(
      'class' => 'btn btn-default'
  )) }}
</p>

{{ Form::open(array(
  'action' => 'MOK\RoleManager\PermissionController@store',
  'class' => 'form-horizontal col-lg-6 col-lg-offset-3',
)) }}

  @include('RoleManager::permissions._form')

  <div class="form-group">
    <div class="col-lg-8 col-lg-offset-4">
      <button type="submit" class="btn btn-info">Save</button>
    </div>
  </div>

{{ Form::close() }}

@stop


