@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Cart</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../css/general.css" rel="stylesheet">
        <link href="../css/checkout.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-4">Cart</h2>

        @if ($cart -> count() <= 0)
          <div class="d-flex flex-column justify-content-center">
            <h3 class="text-center">Cart is empty!</h3>
          </div>
        @else
          <div>
            <div class="cartContainer">
              <div class="cartProductsContainer">
                @foreach ($products as $product)
                  <a href="/shop/product/{{ $product -> id }}" class="cartProductContainerLink">
                    <div class="cartProductContainer">
                      <div></div>
                      <div>
                        <h4>{{ $product -> name }}</h4>
                        @foreach ($cart as $cartItem)
                          @if ($cartItem -> product_id == $product -> id)
                            <span class="fw-bold" style="font-size: 1.2em">{{ $product -> price * $cartItem -> quantity }}</span>
                            <small>{{ $product -> price }} x {{ $cartItem -> quantity }}</small>
                          @endif
                        @endforeach
                      </div>
                    </div>
                  </a>
                @endforeach
              </div>
              <div class="cartTotalsContainer">
                <table class="table table-hover mb-0">
                    <tr>
                      <th>Sub-Total Amount:</th>
                      <td class="text-end">{{ $cartTotal }}</td>
                    </tr>
                    <tr>
                      <th>Total Amount:</th>
                      <td class="text-end">{{ $cartTotal }}</td>
                    </tr>
                    <tr>
                      <th>To Pay:</th>
                      <td class="text-end">{{ $cartTotal }}</td>
                    </tr>
                </table>
              </div>
            </div>
            <div class="d-grid gap-2 mt-3">
              <a href="/checkout/checkout" class="btn btn-success btn-lg" type="button">Proceed to Checkout</a>
              <a href="/" class="btn btn-danger" type="button">Cancel</a>
            </div>
          </div>
        @endif
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
