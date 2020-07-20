<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <h1 class="text-center mt-4">@lang('main.welcome')</h1>
  <div class="container">
  @yield('content')
  </div>
</body>
</html>