@extends('admin::layouts.account')

@section('title', '用户登录')

@section('content')
<form action="{{ route('login.post') }}" method="post">
  <a title="返回首页" href="{{ request()->input('home_url') ? request()->input('home_url') : '/' }}">
    <img class="mb-4" src="/assets/images/home.png" alt="" width="72" height="72">
  </a>
  @csrf
  <h1 class="h3 mb-3 fw-normal">用户登录</h1>
  <input type="hidden" name="redirect_url" value="{{ request()->input('redirect_url') ? request()->input('redirect_url') : '/' }}">
  <div class="form-floating">
    <input type="text" name="username" id="username" class="form-control" placeholder="邮箱/用户名/手机">
    <label for="username">邮箱/用户名/手机</label>
  </div>
  <div class="form-floating">
    <input type="password" name="password" id="password" class="form-control" placeholder="密码">
    <label for="password">密码</label>
  </div>
  <div class="checkbox mb-3">
    <label>
      <input name="remember" type="checkbox">&nbsp;&nbsp;&nbsp;记 住 我
    </label>
  </div>
  @if (count($errors) > 0)
    <div class="mb-3">
      @foreach ($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
      @endforeach
    </div>
  @endif
  <button type="submit" class="w-100 btn btn-lg btn-primary">登 录</button>
  <p class="mt-5 mb-3 text-muted">&copy; {{config('admin.since')}}-{{now()->year}}</p>
</form>
@stop
