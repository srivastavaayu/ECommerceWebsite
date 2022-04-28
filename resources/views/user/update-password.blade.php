@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>EComWeb - Update Password</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href="../css/general.css" rel="stylesheet">
  </head>
  <body>
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <main class="main container-fluid mt-3 mb-5" style="width: 70%">
      <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
      <h2 class="text-center mb-3">Profile</h2>
      <div style="color: blue; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div style="color: blue; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
          @break
        @endforeach
      @endif

      <form method="POST" action="/user/update-password">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="mb-3 mt-3">
          <label class="form-label" for="currentPasswordInput">Current Password*</label>
          <input type="password" class="form-control" id="currentPasswordInput" name="currentPasswordInput" placeholder="Current Password" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$" required>
        </div>
        <small class="px-4">Note: The password must contain atleast 8 and atmost 20 characters including an uppercase character, a lowercase character, a digit and a special symbol.</small>
        <div class="mb-3 mt-3">
          <label class="form-label" for="passwordInput">New Password*</label>
          <input type="password" class="form-control" id="passwordInput" name="passwordInput" placeholder="New Password" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="reenterPasswordInput">Re-enter New Password*</label>
          <input type="password" class="form-control" id="reenterPasswordInput" name="reenterPasswordInput" placeholder="Re-enter New Password" required>
        </div>
        <br />
        <div class="d-flex justify-content-end">
          <a href="/"><button type="button" class="btn btn-danger">Cancel</button></a>
          <button type="submit" class="btn btn-success ms-2">Update Password</button>
        </div>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>
  </body>
</html>
