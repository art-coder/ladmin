@extends('admin::layouts.master')

@section('title')
首页
@stop

@section('content_header')
欢迎来到后台管理系统
@stop

@section('css')
<link rel="stylesheet" href="{{ config('admin.assets_url.bootstrap_switch_css') }}">
@stop

@section('content')
  <div class="box box-primary color-palette-box">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-warning"></i> 后台提示说明管理</h3>
    </div>
    <div class="box-body">
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tr>
            <th>位置</th>
            <th>状态</th>
          </tr>
          @foreach($hints as $hint)
          <tr>
            <td>{{$hint['name']}}</td>
            <td>
              <div class="switch">
                <input data-module="{{$hint['moduleName']}}" data-key="{{$hint['key']}}" name="hitsCheckBox" type="checkbox" {{ $hint['active'] ? 'checked' : '' }} />
              </div>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
<!--[if lt IE 9]>
  <script src="{{ config('admin.assets_url.json') }}"></script>
<![endif]-->
<script src="{{ config('admin.assets_url.bootstrap_switch_js') }}"></script>
<script src="{{ config('admin.assets_url.jquery_cookie') }}"></script>
<script>
$("[name='hitsCheckBox']").bootstrapSwitch();
$('input[name="hitsCheckBox"]').on('switchChange.bootstrapSwitch', function(event, state) {
  var cookies = $.cookie('hints');
  console.log(cookies);
  var moduleName = $(this).attr('data-module');
  var moduleKey = $(this).attr('data-key');
  if(typeof(cookies) == 'undefined'){
    cookies = {};
  } else {
    cookies = JSON.parse(cookies);
  }
  if(typeof(cookies[moduleName]) == 'undefined'){
    cookies[moduleName] = {};
  }
  if(typeof(cookies[moduleName][moduleKey]) == 'undefined'){
    cookies[moduleName][moduleKey] = false;
  }
  cookies[moduleName][moduleKey] = state;
  $.cookie('hints', JSON.stringify(cookies), {
    expires: 7 * 52,
    path: '/',
  });
});
</script>
@stop
