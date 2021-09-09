<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> @yield('layoutTitle') - {{config('admin.title_prefix')}} - {{config('admin.title')}}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ config('admin.assets_url.bootstrap_css') }}">
  <link rel="stylesheet" href="{{ config('admin.assets_url.font_awesome_css') }}">
  <link rel="stylesheet" href="{{ config('admin.assets_url.admin_lte_css') }}">
  <link rel="stylesheet" href="{{ config('admin.assets_url.admin_lte_all_skins_css') }}">
  <link rel="stylesheet" href="/assets/css/admin.css">
  @yield('layoutCss')
  <!--[if lt IE 9]>
  <script src="{{ config('admin.assets_url.htmlshiv_js') }}"></script>
  <script src="{{ config('admin.assets_url.respond_js') }}"></script>
  <![endif]-->
</head>
<body class="hold-transition @yield('layoutBodyClass')">
@yield('layoutBodyContent')
<script src="{{ config('admin.assets_url.jquery_js') }}"></script>
<script src="{{ config('admin.assets_url.bootstrap_js') }}"></script>
<script src="{{ config('admin.assets_url.admin_lte_js') }}"></script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
  });
</script>
@yield('layoutScript')
</body>
</html>
