@extends('admin::layouts.master')

@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    @component('admin::components.button-back', ['title' => $title, 'targetTitle' => $targetTitle, 'targetUrl' => $targetUrl])
    @endcomponent
  </div>
  <form class="form-horizontal" action="{{ $formUrl }}" method="post" enctype="multipart/form-data" role="form" >
    <div class="box-body">
      @csrf
      @yield('hidden')
      @php
        if($moduleName){
          $path = $moduleName . '::' . strtr($folder, '-', '.' ) . '._form';
        } else {
          $path = strtr($folder, '-', '.' ) . '._form';
        }
      @endphp
      @include($path)
    </div>
    <div class="box-footer text-center">
      <button type="reset" class="btn btn-default">重置</button>
      <button type="submit" class="btn btn-info">提交</button>
    </div>
  </form>
</div>
@endsection
