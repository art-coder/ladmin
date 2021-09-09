@extends('admin::layouts.master')

@section('title', '系统配置')

@component('admin::components.button-add', ['title' => '系统配置', 'targetTitle' => '添加配置', 'targetUrl' => route('admin.setting.create')  ])
@endcomponent

@section('content')

<div class="box box-info">
  <div class="box-header with-border"></div>
  <form class="" action="{{ route('admin.setting.index') }}" method="post" enctype="multipart/form-data" role="form" >
    @csrf
    <div class="box-body">
      @foreach($settings as $setting)
        <div class="form-group">
          <label for="{{$setting['item']}}">{{$setting['description']}}({{$setting['item']}}):</label>
          <input type="hidden" name="item[]" value="{{$setting['item']}}">
          @if($setting['type'] == 'input')
            <input type="text" class="form-control" name="content[]" value="{{$setting['content']}}" id="{{$setting['item']}}" />
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
