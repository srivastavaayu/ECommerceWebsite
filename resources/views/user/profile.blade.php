@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Profile</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../css/general.css" rel="stylesheet">
        <link href="../css/user.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 70%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-3">Profile</h2>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
            @break
          @endforeach
        @endif

        <div id="editProfileButton" class="justify-content-end">
          <button type="button" class="btn btn-primary ms-2" onclick="editProfile()">Edit Profile</button>
        </div>
        <form method="POST" action="/user/profile">
          {{ csrf_field() }}
          <div class="mb-3">
            <label class="form-label" for="FullNameInput">Full Name</label>
            <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="{{ $name }}" value="{{ old('FullNameInput') }}" pattern="[A-Za-z0-9 ]+" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label" for="EmailInput">Email Address</label>
            <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="{{ $email }}" value="{{ old('EmailInput') }}" pattern="\S+@\S+\.\S+" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label" for="PhoneNumberInput">Phone Number</label>
            <input type="text" class="form-control" id="PhoneNumberInput" name="PhoneNumberInput" placeholder="{{ $phoneNumber }}" value="{{ old('PhoneNumberInput') }}" pattern="^[0-9]{10}$" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label" for="UsernameInput">Username</label>
            <input type="text" class="form-control" id="UsernameInput" name="UsernameInput" placeholder="{{ $username }}" value="{{ old('UsernameInput') }}" pattern="[A-Za-z0-9]+" readonly>
          </div>
          <div id="editProfileButtons" class="justify-content-end">
            <button type="button" class="btn btn-danger" onclick="editProfile()">Cancel</button>
            <button type="submit" class="btn btn-success ms-2">Update Profile</button>
          </div>
        </form>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script type="text/javascript">
        let editOpen = false;
        function editProfile() {
          if (editOpen === false) {
            editOpen = true;
            let inputFields = document.getElementsByClassName("form-control");
            // for (let i = 0; i<inputFields.length; i++) {
            //   inputFields[i].readOnly = false;
            // }
            Object.keys(inputFields).map((field) => {
              if (field == 0) {
                return false;
              }
              inputFields[field].readOnly = false;
            })
            document.getElementById("editProfileButton").style.display = "none";
            document.getElementById("editProfileButtons").style.display = "flex";
          }
          else {
            editOpen = false;
            let inputFields = document.getElementsByClassName("form-control");
            // for (let i = 1; i<inputFields.length; i++) {
            //   inputFields[i].readOnly = true;
            // }
            Object.keys(inputFields).map((field) => {
              if (field == 0) {
                return false;
              }
              inputFields[field].readOnly = true;
            })
            document.getElementById("editProfileButton").style.display = "flex";
            document.getElementById("editProfileButtons").style.display = "none";
          }
        }
      </script>
    </body>
</html>
