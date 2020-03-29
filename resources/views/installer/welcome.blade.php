@extends('installer.layout')

@section('title')
  {{ trans('installer.welcome.title') }}
@endsection

@section('container')
  <p class="text-center">
    {{ trans('installer.welcome.message') }}
  </p>
  <p class="text-center">
    <a href="{{ route('LaravelInstaller::requirements') }}" class="button">
      {{ trans('installer.welcome.next') }}
      <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </a>
  </p>
@endsection
