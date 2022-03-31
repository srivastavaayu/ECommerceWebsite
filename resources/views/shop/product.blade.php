@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Shop - {{ $product -> name }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../css/general.css" rel="stylesheet">
        <link href="../../css/shop.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>

        <div class="productHeadContainer">
          <div></div>
          <div>
            <small>{{ $category -> name }}</small>
            <h2>{{ $product -> name }}</h2>
            <p>{{ $product -> description }}</p>
            <p class="productPriceContainer">{{ $product -> price }}/{{ $product -> unit }}</p>
            @if ($cart != null)
            <form id="removeFromCart" method="POST" action="/shop/product/{{ $product -> id}}/RemoveFromCart">{{ csrf_field() }}</form>
            <form id="decreaseCartQuantity" method="POST" action="/shop/product/{{ $product -> id}}/DecreaseCartQuantity">{{ csrf_field() }}</form>
            <form id="increaseCartQuantity" method="POST" action="/shop/product/{{ $product -> id}}/IncreaseCartQuantity">{{ csrf_field() }}</form>
            <button class="btn btn-primary mb-2" form="removeFromCart"><img src="../../../images/trash.png" class="productCartImage"> Remove From Cart</button>
              <div class="d-flex flex-row input-group">
                @if ($cart -> quantity <= 1)
                  <button class="btn btn-secondary" form="removeFromCart"><img src="../../../images/trash.png" class="productCartImage"></button>
                @else
                  <button class="btn btn-secondary" form="decreaseCartQuantity"> -1 </button>
                @endif
                <input type="number" class="form-control text-center" name="quantity" value="{{ $cart -> quantity }}" required>
                <button class="btn btn-secondary" form="increaseCartQuantity"> +1 </button>
              </div>
            @else
              <div>
                <form method="POST" action="/shop/product/{{ $product -> id }}/AddToCart">
                  {{ csrf_field() }}
                  <button class="btn btn-primary"><img src="../../../images/cart.png" class="productCartImage"> Add To Cart</button>
                </form>
              </div>
            @endif
            <a href="/shop/cart"><button class="btn btn-success mt-2">Go To Cart</button></a>
          </div>
        </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
