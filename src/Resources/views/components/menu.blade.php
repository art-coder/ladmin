<!-- menu -->
<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
    @foreach ( $menus as $mods )
      @if($mods)
        @foreach ($mods as $item)
          @if (isset($item['submenu']) && $item['submenu'])
            <li class="treeview">
              <a href="javascript:;">
                <i class="fa fa-{{$item['icon']}}"></i>
                <span>{{$item['text']}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @foreach ($item['submenu'] as $menu)
                  @php
                  // dump($menu);
                  @endphp
                  <li class="{{ active_menu($menu) }}">
                    <a href="{{route($menu['route'])}}"><i class="fa fa-{{$menu['icon']}}"></i> {{$menu['text']}}</a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li><a href="{{route($item['route'])}}"><i class="fa fa-{{$item['icon']}}"></i> <span>{{$item['text']}}</span></a></li>
          @endif
        @endforeach
      @endif
    @endforeach

      {{-- <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span>Layout Options</span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">4</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
          <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
          <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
          <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
        </ul>
      </li>
      <li>
        <a href="pages/mailbox/mailbox.html">
          <i class="fa fa-envelope"></i> <span>Mailbox</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-yellow">12</small>
            <small class="label pull-right bg-green">16</small>
            <small class="label pull-right bg-red">5</small>
          </span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-folder"></i> <span>Examples</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
          <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
        </ul>
      </li>
      <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li> --}}
    </ul>
  </section>
</aside>
