@extends('admin::layouts.adminlte')

@section('layoutTitle')
  @yield('title')
@endsection

@section('layoutCss')
  @yield('css')
  <link href="{{config('admin.assets_url.kindeditor_css')}}" rel="stylesheet">
  <link href="{{ config('admin.assets_url.bootstrap_datetimepicker_css') }}" rel="stylesheet">
  @stack('stack_css')
@endsection

@section('layoutBodyClass', 'skin-blue sidebar-mini')

@section('layoutBodyContent')
  <div class="wrapper">
    @include('admin::layouts.components.header')

    <x-admin-menu />

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          @yield("content_header")
        </h1>
        <ol class="breadcrumb">
          @yield("breadcrumb")
        </ol>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            @include('admin::partials.tips')
            @yield("content")
          </div>
        </div>
      </section>
    </div>

    @include('admin::layouts.components.footer')

  </div>
@endsection

@section('layoutScript')
  <script src="{{ config('admin.assets_url.moment_js') }}"></script>
  <script src="{{ config('admin.assets_url.bootstrap_datetimepicker_js') }}"></script>
  <script src="{{config('admin.assets_url.kindeditor_js')}}"></script>
  <script src="{{config('admin.assets_url.kindeditor_lang_js')}}"></script>
  <script src="/assets/js/admin.js"></script>
  @yield("script")
  @stack('stack_script')
@endsection
