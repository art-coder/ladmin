@extends('admin::layouts.error')

@section('title', __($exception->getMessage() ?: 'ERROR'))

@section('code', '401')
@section('message', __($exception->getMessage() ?: 'ERROR'))
