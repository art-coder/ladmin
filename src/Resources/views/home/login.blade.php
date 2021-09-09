@extends('admin::layouts.adminlte')

@section('layoutTitle', '用户登录')

@section('layoutCss')
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ config('admin.assets_url.icheck_css') }}">
@endsection

@section('layoutBodyClass', 'login-page')

@section('layoutBodyContent')
  <div class="login-box">
    <div class="login-logo">
      <b>后台管理系统</b>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">请输入用户名和密码登录系统...</p>

      <form action="{{ route('admin.pl') }}" method="post">
        @csrf
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="用户名">
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="密码">
          <span class="fa fa-key form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input name="remember" type="checkbox">&nbsp;&nbsp;&nbsp;记 住 我
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">登 录</button>
          </div>
        </div>
      </form>

      {{-- <a href="#">I forgot my password</a><br>
      <a href="register.html" class="text-center">Register a new membership</a> --}}

    </div>
  </div>
@endsection

@section('layoutScript')
  <!-- iCheck -->
  <script src="{{ config('admin.assets_url.icheck_js') }}"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
@endsection
