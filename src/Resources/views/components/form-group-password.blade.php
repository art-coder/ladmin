<div class="form-group @error($field) has-error @enderror">
  <label for="{{$field}}" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" name="{{$field}}" id="{{$field}}" value=""  placeholder="{{$title}}">
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>
