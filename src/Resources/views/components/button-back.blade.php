@section('content_header')
  <a class="btn-back" href="{{ $targetUrl }}" title="{{ $targetTitle }}">
    <span class="text-muted fa fa-arrow-circle-left"></span>
    <span class="sr-only">{{ $targetTitle }}</span>
  </a>
  {{ $title }}
@stop
