@include('../header')

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
    <main class="main container-fluid mt-3 mb-5" style="width: 70%">
      <h2 class="text-center mb-3">Register</h2>
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="/register">
        {{ csrf_field() }}
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="Full Name" value="{{ old('FullNameInput') }}" pattern="[A-Za-z0-9 ]+" required>
          <label for="FullNameInput">Full Name*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="Email" value="{{ old('EmailInput') }}" pattern="\S+@\S+\.\S+" required>
          <label for="EmailInput">Email Address*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="PhoneNumberInput" name="PhoneNumberInput" placeholder="Phone Number" value="{{ old('PhoneNumberInput') }}" pattern="^[0-9]{10}$" required>
          <label for="PhoneNumberInput">Phone Number*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="Username" value="{{ old('UsernameInput') }}" pattern="[A-Za-z0-9]+" required>
          <label for="UsernameInput">Username*</label>
        </div>
        <small class="px-4">Note: The password must contain atleast 8 and atmost 20 characters including an uppercase character, a lowercase character, a digit and a special symbol.</small>
        <div class="form-floating mb-3 mt-3">
          <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" placeholder="Password" pattern="^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$" required>
          <label for="PasswordInput">Password*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="ReenterPasswordInput" name="ReenterPasswordInput" placeholder="Re-enter Password" required>
          <label for="ReenterPasswordInput">Re-enter Password*</label>
        </div>
        <br />
        <div class="d-flex justify-content-end">
          <a href="/login" >
            <button type="button" class="btn btn-primary">Already have an account? Login here!</button>
          </a>
          <button type="submit" class="btn btn-success ms-2">Register</button>
        </div>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
