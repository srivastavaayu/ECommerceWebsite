@include('header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="css/general.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main>
        @if (Auth::check())
          <h3 class="text-center mt-5">Hello, <span class="userGreeting">{{ $name }}</span>!</h3>
        @else
          <h3 class="text-center mt-5">Welcome to <span class="userGreeting">EComWeb</span>!</h3>
        @endif
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
