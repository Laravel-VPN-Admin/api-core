<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>{{ config('app.name', 'Laravel VPN Admin') }}</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!-- Styles stacked -->
  @stack('header:styles')

</head>
<body>

<main>
  @yield('content')
</main>

<!-- Scripts stacked -->
@stack('footer:scripts')

</body>
</html>
