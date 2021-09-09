@extends('admin::layouts.master')

@section('title', '角色列表')

@component('admin::components.button-add', ['title' => '角色列表', 'targetTitle' => '添加角色', 'targetUrl' => route('admin.role.create', ['page' => request()->input('page') ])  ])
@endcomponent

@section('content')
<div class="box box-primary">
  <div class="box-body no-padding">
    <table class="table table-striped table-hover">
      <tr>
        <th style="width: 10px">#</th>
        <th>角色名称</th>
        <th style="width: 100px">操作</th>
      </tr>
      @foreach($list as $val)
        <tr>
          <td>{{$val->id}}</td>
          <td>{{$val->name}}</td>
          <td>
            @component('admin::components.operation-model', ['folder' => 'role', 'model' => $val ])
            @endcomponent
          </td>
        </tr>
      @endforeach
    </table>
  </div>
  <div class="box-footer text-center">
    {{ $list->links() }}
  </div>
</div>
@stop
