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