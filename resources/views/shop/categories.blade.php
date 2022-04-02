@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Shop - Categories</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../css/general.css" rel="stylesheet">
        <link href="../css/shop.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-3">Shop - Categories</h2>

        @if ($categories -> count() <= 0)
          <h3 class="text-center">No categories to show!</h3>
        @else
          <div class="mt-4 categoriesContainer text-center">
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
          <div class="d-flex justify-content-center mt-4">
            @if ($categories -> previousPageUrl() != "")
              <a href="{{ $categories -> previousPageUrl() }}"><button class="btn btn-secondary">&larr; Previous</button></a>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
            @if ($categories -> nextPageUrl() != "")
              <a href="{{ $categories -> nextPageUrl() }}"><button class="btn btn-secondary">Next &rarr;</button></a>
            @endif
          </div>
        @endif
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>