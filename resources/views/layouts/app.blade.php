<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  @include('layouts.head')
</head>
<body>

@include('layouts.navbar')

<main id="app">
  @yield('content')
</main>

@include('layouts.footer')
@stack('footer:scripts')

</body>
</html>
