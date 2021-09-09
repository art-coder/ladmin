@section('content_header')
  <a href="{{$targetUrl}}" class="btn-add" title="{{ $targetTitle }}">
    <i class="fa fa-plus-circle"></i><span class="sr-only">{{ $targetTitle }}</span>
  </a>
  {{ $title }}
@stop
