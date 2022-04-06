@include('header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EComWeb</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/general.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
  </head>
  <body>
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <main class="main container-fluid mt-3 mb-5" style="width: 95%">
      @if (Auth::check())
        <h3 class="text-center mt-5">Hello, <span class="userGreeting">{{ $name }}</span>!</h3>
      @else
        <h3 class="text-center mt-5">Welcome to <span class="userGreeting">EComWeb</span>!</h3>
      @endif

      <div>
        <h3>Categories</h3>
        @if ($categories -> count() <= 0)
          <p>No categories available!</p>
        @else
          <div class="mt-1 mb-3 categoriesContainer text-center justify-content-start">
            @foreach ($categories as $category)
              <a class="categoryLinkContainer" href="/shop/category/{{ $category -> id }}">
                <button class="categoryButtonContainer">
                  <div class="categoryContainer d-flex flex-column justify-content-center">
                    <h4 class="categoryTitleText text-truncate">{{ $category -> name }}</h4>
                    <p class="text-truncate">{{ $category -> description }}</p>
                  </div>
                </button>
              </a>
            @endforeach
          </div>
        @endif
      </div>
      <div>
        <h3>Products</h3>
        @if ($products -> count() <= 0)
          <p>No products available!</p>
        @else
          <div class="mt-1 productsContainer text-center justify-content-start">
            @foreach ($products as $product)
              <a class="productLinkContainer" href="/shop/product/{{ $product -> id }}">
                <button class="productButtonContainer">
                  <div class="productContainer">
                    <div class="mb-3" style="height: 50%;"><img src="{{ asset(Storage::url($product -> image_path)) }}" /></div>
                    <div>
                      <h4 class="productTitleText text-truncate">{{ $product -> name }}</h4>
                      <p class="mb-1 text-truncate">{{ $product -> description }}</p>
                      <p class="productPriceContainer mb-1 text-truncate">{{ $product -> price }}/{{ $product -> unit }}</p>
                      @if ($product -> quantity <= 0)
                        <small style="color: red;">Out of stock!</small>
                      @endif
                    </div>
                  </div>
                </button>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
