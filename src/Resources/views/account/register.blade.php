@extends('admin::layouts.account')

@section('title', '用户登录')

@section('content')
<form action="{{ route('register.post') }}" method="post">
  <a title="返回首页" href="{{ request()->input('home_url') ? request()->input('home_url') : '/' }}">
    <img class="mb-4" src="/assets/images/home.png" alt="" width="72" height="72">
  </a>
  @csrf
  <h1 class="h3 mb-3 fw-normal">用户注册</h1>
  <input type="hidden" name="redirect_url" value="{{ request()->input('redirect_url') ? request()->input('redirect_url') : '/' }}">
  <div class="form-floating">
    <input type="text" name="username" id="username" class="form-control" placeholder="昵称">
    <label for="username">昵称</label>
  </div>

  <div class="form-floating">
    <input type="text" name="email" id="email" class="form-control" placeholder="邮箱">
    <label for="email">邮箱</label>
  </div>

  <div class="form-floating">
    <input type="text" name="phone" id="phone" class="form-control" placeholder="手机号">
    <label for="phone">手机号</label>
  </div>

  <div class="form-floating">
    <input type="password" name="password" id="password" class="form-control" placeholder="密码">
    <label for="password">密码</label>
  </div>

  <div class="form-floating">
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="确认密码">
    <label for="password_confirmation">确认密码</label>
  </div>

  @if (count($errors) > 0)
    <div class="mb-3">
      @foreach ($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <button type="submit" class="w-100 btn btn-lg btn-primary">注 册</button>
  <p class="mt-5 mb-3 text-muted">&copy; {{config('admin.since')}}-{{now()->year}}</p>
</form>
@stop
