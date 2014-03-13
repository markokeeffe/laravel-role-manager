<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
  {{ Form::label('name', 'Name', array(
    'class' => 'control-label col-lg-4',
  )) }}
  <div class="col-lg-8">
    {{ Form::text('name', Input::old('name'), array(
      'class' => 'form-control',
    )) }}
    {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
  </div>
</div>
<div class="form-group {{ $errors->has('display_name') ? 'error' : '' }}">
  {{ Form::label('display_name', 'Display Name', array(
    'class' => 'control-label col-lg-4',
  )) }}
  <div class="col-lg-8">
    {{ Form::text('display_name', Input::old('display_name'), array(
      'class' => 'form-control',
    )) }}
    {{ $errors->first('display_name', '<span class="help-inline">:message</span>') }}
  </div>
</div>