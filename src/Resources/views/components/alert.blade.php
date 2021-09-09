<div class="alert alert-{{$type}} alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <h4><i class="icon fa fa-info"></i> {{$title}}</h4>
  <ol>
    {{ $slot }}
  </ol>
</div>
