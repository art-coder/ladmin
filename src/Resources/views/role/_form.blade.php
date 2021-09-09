{!! operation_hints($moduleName, 'permissionList') !!}

@section('title', $title)


@component('admin::components.form-group', ['title' => '角色名称', 'field' => 'name', 'model' => $role, 'errors' => $errors ])
@endcomponent

<div class="form-group">
  <label class="col-sm-2 control-label">权限列表</label>
  <div class="col-sm-10">
    <div class="form-group" style="margin-top: 6px;">
      @foreach($permission as $value)
        <div class="row">
          <div class="col-md-2 text-right"><strong>{{$value['title']}}：</strong></div>
          <div class="col-md-10">
            @foreach($value['list'] as $val)
              <label class="normal">
                <input type="checkbox" class="flat-red" name="pids[]" value="{{$val['id']}}" @if($val['checked']) checked="checked" @endif />
                {{$val['name']}}
              </label>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
