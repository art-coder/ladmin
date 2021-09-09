<div class="form-group @error($field) has-error @enderror">
  <label for="{{$field}}" class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <select id="{{$field}}" class="form-control" name="{{$field}}">
      <option value="0">{{ isset($zero) ? $zero : '请选择' . $title }}</option>
      @foreach($list as $val)
        <option value="{{ $val['id'] }}" {{ $val['id'] == $model->$field ? 'selected' : '' }}>
          @if (isset($val['level']))
            {!! str_pad('|', $val->level + 2, '+') !!}
          @endif
          {{ $val['name'] }}
        </option>
      @endforeach
    </select>
    @error($field)
      <span class="help-block">{{ $message }}</span>
    @enderror
  </div>
</div>
