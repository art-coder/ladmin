@extends('admin::layouts.master')

@section('title', '敏感词管理')

@section('content')
<form method="POST" action="">
  @csrf
  <p>
    <label>敏感词汇(每个敏感词一行)</label>
    <br />
    <textarea class="text" name="keywords" rows="3">{{$keywords}}</textarea>
  </p>

  <p>
    <input class="submit" type="submit" value="添加" />
  </p>
</form>
@stop
