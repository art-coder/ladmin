@extends('admin::layouts.master')

@section('title', '权限列表')

@component('admin::components.button-add', ['title' => '权限列表', 'targetTitle' => '添加权限', 'targetUrl' => route('admin.permission.create', ['page' => request()->input('page') ])  ])
@endcomponent

@section('content')
<div class="box box-primary">
  <div class="box-header with-border">
    {!! operation_hints('admin', 'permissionList') !!}
  </div>
  <div class="box-body no-padding">
    <table class="table table-striped table-hover">
      <tr>
          <th style="width: 10px">#</th>
          <th>权限名称</th>
          <th>权限描述</th>
          <th style="width: 100px">操作</th>
      </tr>
      @foreach($list as $val)
        <tr>
          <td>{{$val->id}}</td>
          <td>{{$val->name}}</td>
          <td>{{$val->info}}</td>
          <td>
            @component('admin::components.operation', ['editRoute' => 'admin.permission.edit', 'deleteRoute' => 'admin.permission.delete', 'id' => $val->id ])
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
