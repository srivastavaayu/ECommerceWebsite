@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>EComWeb - Thank You</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href="../css/general.css" rel="stylesheet">
      <link href="../css/user.css" rel="stylesheet">
  </head>
  <body>
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <main class="main container-fluid mt-3 mb-5" style="width: 95%">
      <h2 class="text-center mt-5 mb-3">Order Summary</h2>
      <div class="orderSummaryContainer">
        <div class="customerInformationContainer">
          <h4>Customer Information</h4>
          <p>
            {{ $user -> name }}<br />
            {{ $user -> phone_number }}<br />
            {{ $user -> email }}<br />
            {{ $order -> address_line_1 }}<br />
            {{ $order -> address_line_2 }}<br />
            {{ $order -> city }} - {{ $order -> pin_code }},
            {{ $order -> state }}, {{ $order -> country }}
          </p>
        </div>
        <div>
          <h4>Items Summary</h4>
          @foreach($products as $product)
            <div class="orderProductContainer">
              <div class="orderProductImageContainer text-center">
                <img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;" />
              </div>
              <div>
                <h4>{{ $product -> name }}</h4>
                <p>{{ $product -> description }}</p>
                @foreach ($items as $item)
                  @if ($item -> item_id == $product -> id)
                    <span class="fw-bold" style="font-size: 1.2em">{{ $product -> price * $item -> quantity }}</span>
                    <small>{{ $product -> price }} x {{ $item -> quantity }}</small>
                  @endif
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
        <div>
          <h4>Payment Summary</h4>
          Payment of {{ $order -> total }} through Cash on Delivery (CoD).
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
