<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>{{ config('app.name', 'Laravel VPN Admin') }}</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favions -->
  <link rel="icon" type="image/png" sizes="64x64" href="/images/favicon/favicon-64x64.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/images/favicon/favicon-48x48.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <!-- Styles stacked -->
  @stack('header:styles')

</head>
<body>

@inertia

<!-- Scripts -->
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>

<!-- Scripts stacked -->
@stack('footer:scripts')

</body>
</html>
