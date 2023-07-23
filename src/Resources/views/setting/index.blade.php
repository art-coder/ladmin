@extends('admin::layouts.master')

@section('title', '系统配置')

@section('css')
<link href="{{config('admin.assets_url.icheck_css')}}" rel="stylesheet">
@stop

@component('admin::components.button-add', ['title' => '系统配置', 'targetTitle' => '添加配置', 'targetUrl' => route('admin.setting.create')  ])
@endcomponent

@section('content')

<div class="box box-info">
  <div class="box-header with-border"><h3 class="box-title"><i class="fa fa-warning"></i> 系统配置</h3></div>
  <form class="" action="{{ route('admin.setting.index') }}" method="post" enctype="multipart/form-data" role="form" >
    @csrf
    <div class="box-body">
      @foreach($settings as $setting)
        <div class="form-group">
          <label for="{{$setting['item']}}">{{$setting['description']}}({{$setting['item']}}):</label>
          <input type="hidden" name="item[]" value="{{$setting['item']}}">
          @if($setting['type'] == 'input')
            <input type="text" class="form-control" name="content[]" value="{{$setting['content']}}" id="{{$setting['item']}}" />
          @elseif ($setting['type'] == 'radio')
            @php
              $items = explode("\r\n", $setting['content']);
              $radio_list = [];
              if ($items) {
                foreach ($items as $item) {
                  $values = explode('|', $item);
                  if (count($values) !== 2) continue;
                  array_push($radio_list, [
                    'name'  => $values[0],
                    'value' => $values[1]
                  ]);
                }
              }
            @endphp
            <div class="form-group">
              @foreach ($radio_list as $radio)
                <input
                  class="flat-red"
                    @if ($radio['value'] == $setting['value'])
                      checked
                    @endif
                  type="radio"
                  name="content[]"
                  value="{{$radio['value']}}" /> {{$radio['name']}}
              @endforeach
            </div>
          @elseif ($setting['type'] == 'checkbox')
            @php
              $items = explode("\r\n", $setting['content']);
              $checkbox_list = [];
              if ($items) {
                foreach ($items as $item) {
                  $values = explode('|', $item);
                  if (count($values) !== 2) continue;
                  array_push($checkbox_list, [
                    'name'  => $values[0],
                    'value' => $values[1]
                  ]);
                }
              }
            @endphp
            <div class="form-group">
              @foreach ($checkbox_list as $checkbox)
                <input
                  class="flat-red"
                    @if (in_array($checkbox['value'], explode(',', $setting['value'])))
                      checked
                    @endif
                  type="checkbox"
                  name="{{$setting['item']}}[]"
                  value="{{$checkbox['value']}}" /> {{$checkbox['name']}}
              @endforeach
            </div>
          @else
            <textarea name="content[]" class="form-control" rows="5" id="{{$setting['item']}}">{{$setting['content']}}</textarea>
          @endif
        </div>
      @endforeach
    </div>
    <div class="box-footer text-center">
      <button type="reset" class="btn btn-default">重置</button>
      <button type="submit" class="btn btn-info">提交</button>
    </div>
  </form>
</div>
@stop

@section('script')
<script src="{{config('admin.assets_url.icheck_js')}}"></script>
<script>
//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
  checkboxClass: 'icheckbox_flat-green',
  radioClass   : 'iradio_flat-green'
})
</script>
@stop

