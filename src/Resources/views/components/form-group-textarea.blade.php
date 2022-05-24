<div class="form-group @error($field) has-error @enderror">
  <label for="{{$field}}" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <textarea name="{{$field}}" id="{{$field}}" class="form-control" rows="5">{{$model->$field}}</textarea>
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>
