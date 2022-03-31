@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Shop - Products</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../css/general.css" rel="stylesheet">
        <link href="../../css/shop.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-3">Shop - {{ $category -> name }}</h2>

        <div class="mt-4 productsContainer text-center">
          @foreach ($products as $product)
            <a class="productLinkContainer" href="/shop/product/{{ $product -> id }}">
              <button class="productButtonContainer">
                <div class="productContainer">
                  <h4 class="productTitleText text-truncate">{{ $product -> name }}</h4>
                  <p class="mb-1 text-truncate">{{ $product -> description }}</p>
                  <p class="mb-1 productPriceContainer">{{ $product -> price }}/{{ $product -> unit }}</p>
                </div>
              </button>
            </a>
          @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
          @if ($products -> previousPageUrl() != "")
            <a href="{{ $products -> previousPageUrl() }}"><button class="btn btn-secondary">&larr; Previous</button></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          @endif
          @if ($products -> nextPageUrl() != "")
            <a href="{{ $products -> nextPageUrl() }}"><button class="btn btn-secondary">Next &rarr;</button></a>
          @endif
        </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
