@extends('admin::layouts.master')

@section('title', '用户列表')

@component('admin::components.button-add', ['title' => '用户列表', 'targetTitle' => '添加用户', 'targetUrl' => route('admin.user.create', ['page' => request()->input('page') ])  ])
@endcomponent

@section('content')
<div class="box">
  @component('admin::components.box-search', ['title' => '用户列表', 'hintsKey' => 'userList', 'placeholder' => '搜索用户', 'searchUrl' => route('admin.user.search'), 'keywords' => isset($keywords) ? $keywords : ''  ])
  @endcomponent
  <div class="box-body no-padding">
    <table class="table table-striped table-hover">
      <tr>
        <th style="width: 10px">#ID</th>
        <th>昵称</th>
        <th>邮箱</th>
        <th>电话</th>
        <th>状态</th>
        <th style="width: 100px">操作</th>
      </tr>
      @foreach($list as $val)
        <tr>
          <td>{{$val->id}}</td>
          <td>{{$val->username}}</td>
          <td>{{$val->email}}</td>
          <td>{{$val->phone}}</td>
          <td>
            @component('admin::components.state', [ 'item' => $val->getState() ])
            @endcomponent
          </td>
          <td>
            @component('admin::components.operation-model', ['folder' => 'user', 'model' => $val ])
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
