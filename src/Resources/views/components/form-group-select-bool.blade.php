<div class="form-group @error($field) has-error @enderror">
  <label for="{{$field}}" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <select id="{{$field}}" class="form-control @if(isset($hasClass)) {{$hasClass}} @endif" name="{{$field}}">
      <option value="0" {{ old($field, $model->$field) === 0 ? 'selected' : '' }}>{{$bool[0]}}</option>
      <option value="1" {{ old($field, $model->$field) === 1 ? 'selected' : '' }}>{{$bool[1]}}</option>
    </select>
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>
