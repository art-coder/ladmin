@extends('admin::layouts.master')

@section('title', '修改密码')

@section('content')
  <div class="box box-info">
    <div class="box-header with-border"><h3 class="box-title">修改密码</h3></div>
    <form class="form-horizontal" action="{{ route('admin.setting.password') }}" method="post" enctype="multipart/form-data" role="form" >
      @csrf
      <div class="box-body">
        <div class="form-group {{ echo_class_error($errors, 'old_pwd') }}">
            <label for="old_pwd" class="col-sm-2 control-label">旧密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="old_pwd" id="old_pwd" placeholder="旧密码">
                {!! echo_error($errors, 'old_pwd') !!}
            </div>
        </div>

        <div class="form-group {{ echo_class_error($errors, 'password') }}">
            <label for="password" class="col-sm-2 control-label">新密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="password" placeholder="新密码">
                {!! echo_error($errors, 'password') !!}
            </div>
        </div>

        <div class="form-group {{ echo_class_error($errors, 'password_confirmation') }}">
            <label for="password_confirmation" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="确认密码">
                {!! echo_error($errors, 'password_confirmation') !!}
            </div>
        </div>
      </div>
      <div class="box-footer text-center">
          <button type="reset" class="btn btn-default">重置</button>
          <button type="submit" class="btn btn-info">提交</button>
      </div>
    </form>
  </div>
@stop
