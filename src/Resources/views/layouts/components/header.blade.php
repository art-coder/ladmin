<header class="main-header">
  <a href="{{route('admin.home.index')}}" class="logo">
    <span class="logo-mini">{{config('admin.logo_mini')}}</span>
    <span class="logo-lg">{{config('admin.logo')}}</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="javascript:;" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only fa fa-bars">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ auth()->user()->avatar }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ auth()->user()->username }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ auth()->user()->avatar }}" class="img-circle" alt="User Image">
              <p>
                {{ auth()->user()->username }} - [ {{ auth()->user()->roleExhibition() }} ]
                <small>注册时间 - {{ auth()->user()->created_at }}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{route('admin.setting.password')}}" class="btn btn-default btn-flat">修改密码</a>
              </div>
              <div class="pull-right">
                <a href="{{route('admin.logout')}}" class="btn btn-default btn-flat">退出</a>
              </div>
            </li>
          </ul>
        </li>
        <li>
          <a href="javascript:;" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- skins -->
<aside class="control-sidebar control-sidebar-dark" style="display: none;">
  <div class="tab-content">
    <div class="tab-pane" id="control-sidebar-skins-tab"></div>
  </div>
</aside>
