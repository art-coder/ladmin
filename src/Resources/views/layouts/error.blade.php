@extends('admin::layouts.adminlte')

@section('layoutTitle')
  @yield('title')
@endsection

@section('layoutCss')
  @yield('css')
@endsection

@section('layoutBodyClass', 'skin-blue sidebar-mini')

@section('layoutBodyContent')
<div class="wrapper">
    @include('admin::layouts.components.header')

    <div class="content-wrapper">

      <section class="content">
        <div class="error-page">
          <h2 class="headline text-yellow"> @yield('code')</h2>

          <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i><b> @yield('message')</b></h3>
            <p>哦豁，o(╥﹏╥)o  发生了一些错误！！</p>
            <p>您可以联系管理员，他会协助您解决这个问题！！</p>
            <p>当然，您也可以点击 <a href="{{ route('admin.home.index') }}">这里</a> 离开此页面</p>
          </div>
        </div>
      </section>
    </div>

    @include('admin::layouts.components.footer')
  </div>
@endsection

@section('layoutScript')
  <script src="/assets/js/admin.js"></script>
  @yield("script")
@endsection
