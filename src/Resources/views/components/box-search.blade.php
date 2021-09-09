<div class="box-header with-border">
  {!! operation_hints($moduleName, isset($hintsKey) ? $hintsKey : 'none') !!}
  <h3 class="box-title">{{$title}}</h3>
  <div class="box-tools pull-right">
    <div class="has-feedback">
      <form class="form-horizontal" action="{{ $searchUrl }}" method="get" role="form" >
        <input name="keywords" type="text" class="form-control input-sm" placeholder="{{$placeholder}}" value="{{ isset($keywords) ? $keywords : '' }}">
        <span class="glyphicon glyphicon-search form-control-feedback"></span>
      </form>
    </div>
  </div>
</div>
