@extends('admin::layouts.error')

@section('title', __($exception->getMessage() ?: 'ERROR'))

@section('code', '403')
@section('message', __($exception->getMessage() ?: 'ERROR'))
