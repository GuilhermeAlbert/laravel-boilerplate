<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @include('layouts.includes.assets.meta')

  <title>{{ config('app.name', 'Laravel') }}</title>

  @include('layouts.includes.assets.favicon')
  @include('layouts.includes.assets.font')
  @include('layouts.includes.assets.style')
</head>

<body>
  <div id="app" class="app">
    @section('content')
    @show

    @include('layouts.includes.footer')
  </div>

  @include('layouts.includes.assets.script')
</body>

</html>