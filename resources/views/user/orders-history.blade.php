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
        <h2 class="text-center mb-3">Orders History</h2>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
            @break
          @endforeach
        @endif

        <div>
          @if ($orders -> count() <= 0)
            <h4>No orders to show!</h4>
          @else
            @foreach ($orders as $order)
              <a href="/user/orders-history?orderId={{ $order -> id }}" style="color: black; text-decoration: none;">
                <div class="orderContainer mb-2 p-4">
                  <p>Order ID: <span class="fw-bold">ECW-{{ $order -> id }}</span></p>

                  <p>
                    Delivery Address: <br />
                    {{ $user -> name }}<br />
                    {{ $user -> phone_number }}<br />
                    {{ $user -> email }}<br />
                    {{ $order -> address_line_1 }}<br />
                    {{ $order -> address_line_2 }}<br />
                    {{ $order -> city }} - {{ $order -> pin_code }},
                    {{ $order -> state }}, {{ $order -> country }}
                  </p>
                </div>
              </a>
            @endforeach
          @endif
        </div>
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
              inputFields[field].value = "";
              inputFields[field].readOnly = true;
            })
            document.getElementById("editProfileButton").style.display = "flex";
            document.getElementById("editProfileButtons").style.display = "none";
          }
        }
      </script>
    </body>
</html>
