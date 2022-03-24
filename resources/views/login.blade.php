@include('header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Register</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="css/general.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3" style="width: 70%">
        <h2 class="text-center mb-3">Login</h2>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
            @break
          @endforeach
        @endif

        <form class="mb-5" method="POST" action="/login">
          {{ csrf_field() }}
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" pattern="[A-Za-z0-9]+" required>
            <label for="UsernameInput">Username*</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" required>
            <label for="PasswordInput">Password*</label>
          </div>
          <div class="d-flex justify-content-end">
            <a href="/register"><button type="button" class="btn btn-primary">New to PHP Blog? Register here!</button></a>
            <button type="submit" class="btn btn-success ms-2">Login</button>
          </div>
        </form>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
