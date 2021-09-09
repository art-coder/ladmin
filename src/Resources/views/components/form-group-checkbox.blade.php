<div class="form-group">
  <label class="col-sm-2 control-label">{{$title}}</label>
  <div class="col-sm-10">
    <div class="form-group">
      @foreach($list as $val)
        <label>
          <input
            type="checkbox"
            class="flat-red"
            name="{{$field}}[]"
            value="{{$val->id}}"
            @if(in_array($val->id, $default)) checked="checked" @endif
            />
            {{$val->name}}
        </label>
      @endforeach
    </div>
    @if (isset($hasCheck) && $hasCheck)
      <input type="hidden" name="has_{{$field}}" value="1" />
    @endif
  </div>
</div>
