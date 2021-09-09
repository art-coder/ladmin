<div class="form-group @error($field) has-error @enderror">
  <label for="{{$field}}" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <input type="text"
      class="form-control @if(isset($hasClass)) {{$hasClass}} @endif"
      name="{{$field}}"
      id="{{$field}}"
      value="{{old($field, $model->$field)}}"
      placeholder="{{$title}}"
    />
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>
