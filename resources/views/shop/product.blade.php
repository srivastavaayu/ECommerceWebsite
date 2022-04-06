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
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <main class="main container-fluid mt-3 mb-5" style="width: 95%">
      <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>

      <div class="productHeadContainer">
        <div class="productImageContainer text-center">
          <img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;" />
        </div>
        <div>
          <small>{{ $category -> name }}</small>
          <h2>{{ $product -> name }}</h2>
          <div class="d-flex flex-row gap-1 mb-3">
            <div id="star1" class="star star1"></div>
            <div id="star2" class="star star2"></div>
            <div id="star3" class="star star3"></div>
            <div id="star4" class="star star4"></div>
            <div id="star5" class="star star5"></div>
          </div>
          <p>{{ $product -> description }}</p>
          <p class="productPriceContainer">{{ $product -> price }}/{{ $product -> unit }}</p>
          @if ($product -> is_archived == 1)
            <div>
                @if ($cart != null)
                  <form id="removeFromCart" method="POST" action="/shop/product/{{ $product -> id}}/removeFromCart">{{ csrf_field() }}</form>
                  <button class="btn btn-primary mb-2" form="removeFromCart"><img src="../../../images/trash.png" class="productCartImage"> Remove From Cart</button>
                @endif
                <p style="color: red; font-size: 1.1em;">Product is not available for purchase!</p>
            </div>
          @else
            @if ($cart != null)
              <form id="removeFromCart" method="POST" action="/shop/product/{{ $product -> id}}/removeFromCart">{{ csrf_field() }}</form>
              <form id="decreaseCartQuantity" method="POST" action="/shop/product/{{ $product -> id}}/decreaseCartQuantity">{{ csrf_field() }}</form>
              <form id="increaseCartQuantity" method="POST" action="/shop/product/{{ $product -> id}}/increaseCartQuantity">{{ csrf_field() }}</form>
              <button class="btn btn-primary mb-2" form="removeFromCart"><img src="../../../images/trash.png" class="productCartImage"> Remove From Cart</button>
              <div class="d-flex flex-row input-group">
                @if ($cart -> quantity <= 1)
                  <button class="btn btn-secondary" form="removeFromCart"><img src="../../../images/trash.png" class="productCartImage"></button>
                @else
                  <button class="btn btn-secondary" form="decreaseCartQuantity"> -1 </button>
                @endif
                <form method="POST" action="/shop/product/{{ $product -> id}}/setCartQuantity">
                  {{ csrf_field() }}
                  <input type="number" class="form-control text-center" name="quantity" value="{{ $cart -> quantity }}" min="1" max="{{ $product -> quantity }}" onchange="this.form.submit()" required>
                </form>
                @if ($cart -> quantity >= $product -> quantity)
                  <button class="btn btn-secondary" form="increaseCartQuantity" disabled> +1 </button>
                @else
                  <button class="btn btn-secondary" form="increaseCartQuantity"> +1 </button>
                @endif
              </div>
              <a href="/checkout/cart"><button class="btn btn-success mt-2">Go To Cart</button></a>
            @else
              <div>
                @if ($product -> quantity > 0)
                  <form method="POST" action="/shop/product/{{ $product -> id }}/addToCart">
                    {{ csrf_field() }}
                    <button class="btn btn-primary"><img src="../../../images/cart.png" class="productCartImage"> Add To Cart</button>
                  </form>
                @else
                  <p style="color: red; font-size: 1.1em;">Product out of stock!</p>
                @endif
              </div>
            @endif
          @endif
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript">
      document.getElementById("star1").addEventListener("mouseenter", function(event) {
        document.getElementById("star1").style.backgroundColor = "#FFD700";
      })
      document.getElementById("star1").addEventListener("mouseleave", function(event) {
        document.getElementById("star1").style.backgroundColor = "unset";
      })
      document.getElementById("star2").addEventListener("mouseenter", function(event) {
        document.getElementById("star1").style.backgroundColor = "#FFD700";
        document.getElementById("star2").style.backgroundColor = "#FFD700";
      })
      document.getElementById("star2").addEventListener("mouseleave", function(event) {
        document.getElementById("star1").style.backgroundColor = "unset";
        document.getElementById("star2").style.backgroundColor = "unset";

      })
      document.getElementById("star3").addEventListener("mouseenter", function(event) {
        document.getElementById("star1").style.backgroundColor = "#FFD700";
        document.getElementById("star2").style.backgroundColor = "#FFD700";
        document.getElementById("star3").style.backgroundColor = "#FFD700";
      })
      document.getElementById("star3").addEventListener("mouseleave", function(event) {
        document.getElementById("star1").style.backgroundColor = "unset";
        document.getElementById("star2").style.backgroundColor = "unset";
        document.getElementById("star3").style.backgroundColor = "unset";
      })
      document.getElementById("star4").addEventListener("mouseenter", function(event) {
        document.getElementById("star1").style.backgroundColor = "#FFD700";
        document.getElementById("star2").style.backgroundColor = "#FFD700";
        document.getElementById("star3").style.backgroundColor = "#FFD700";
        document.getElementById("star4").style.backgroundColor = "#FFD700";
      })
      document.getElementById("star4").addEventListener("mouseleave", function(event) {
        document.getElementById("star1").style.backgroundColor = "unset";
        document.getElementById("star2").style.backgroundColor = "unset";
        document.getElementById("star3").style.backgroundColor = "unset";
        document.getElementById("star4").style.backgroundColor = "unset";
      })
      document.getElementById("star5").addEventListener("mouseenter", function(event) {
        document.getElementById("star1").style.backgroundColor = "#FFD700";
        document.getElementById("star2").style.backgroundColor = "#FFD700";
        document.getElementById("star3").style.backgroundColor = "#FFD700";
        document.getElementById("star4").style.backgroundColor = "#FFD700";
        document.getElementById("star5").style.backgroundColor = "#FFD700";
      })
      document.getElementById("star5").addEventListener("mouseleave", function(event) {
        document.getElementById("star1").style.backgroundColor = "unset";
        document.getElementById("star2").style.backgroundColor = "unset";
        document.getElementById("star3").style.backgroundColor = "unset";
        document.getElementById("star4").style.backgroundColor = "unset";
        document.getElementById("star5").style.backgroundColor = "unset";
      })
    </script>
  </body>
</html>
