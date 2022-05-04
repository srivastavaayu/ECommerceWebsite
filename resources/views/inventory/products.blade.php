@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>EComWeb - Inventory - Products</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href="../css/general.css" rel="stylesheet">
      <link href="../css/inventory.css" rel="stylesheet">
  </head>
  <body>
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <main class="main container-fluid mt-3 mb-5" style="width: 95%">
      <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
      <h2 class="text-center mb-3">Inventory - Products</h2>
      <div style="color: blue; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
      <div class="d-flex justify-content-center">
        <a href="/inventory/product/product">
          <button type="button" class="btn btn-primary">Add New Product</button>
        </a>
      </div>

      <div class="d-flex justify-content-between">
        <form method="POST" action="/inventory/product">
          {{ method_field('PATCH') }}
          {{ csrf_field() }}
          <div class="btn-group" role="group">
            @if ($viewStyle == 'tabular')
              <input type="radio" class="btn-check" name="view" value="tabular" id="tabularView" onclick="this.form.submit()" checked>
              <label class="btn btn-outline-primary" for="tabularView">Table View</label>
              <input type="radio" class="btn-check" name="view" value="listicle" id="listicleView" onclick="this.form.submit()">
              <label class="btn btn-outline-primary" for="listicleView">Listicle View</label>
            @else
              <input type="radio" class="btn-check" name="view" value="tabular" id="tabularView" onclick="this.form.submit()">
              <label class="btn btn-outline-primary" for="tabularView">Table View</label>
              <input type="radio" class="btn-check" name="view" value="listicle" id="listicleView" onclick="this.form.submit()" checked>
              <label class="btn btn-outline-primary" for="listicleView">Listicle View</label>
            @endif
          </div>
        </form>
        <form method="GET" action="/inventory/product">
          {{ csrf_field() }}
          <input type="hidden" name="sort" value="{{ $sortBehavior == 'ASC' ? 'DESC' : 'ASC' }}"></input>
          <button type="submit" class="btn btn-primary">Sort By: Date ({{ $sortBehavior == "ASC" ? "&uarr;" : "&darr;" }})</button>
        </form>
      </div>

      @if ($viewStyle == 'tabular')
        <div id="tabularDataView" class="mt-4">
          <nav>
            <div class="d-flex justify-content-evenly nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All Products</button>
              <button class="nav-link" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Active Products</button>
              <button class="nav-link" id="nav-archive-tab" data-bs-toggle="tab" data-bs-target="#nav-archived" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Archived Products</button>
            </div>
          </nav>
          <div class="tab-content mt-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              @if (!$allProducts -> count())
                <h4 class="d-flex justify-content-center">No products to show!</h4>
              @else
                <table class="table table-hover text-center align-middle">
                  <thead>
                    <tr>
                      <th>Stock Keeping Unit (SKU)</th>
                      <th>Product Name</th>
                      <th>Available Quantity</th>
                      <th>Product Status</th>
                      <th>Edit</th>
                      <th>Archive/Unarchive</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($allProducts as $index => $product)
                      <tr>
                        <td>{{ $product -> sku }}</td>
                        <td>{{ $product -> name }}</td>
                        <td>{{ $product -> quantity }}</td>
                        <td>
                          @if ($product -> is_archived)
                            <span class="badge rounded-pill bg-danger">Archived</span>
                          @else
                            <span class="badge rounded-pill bg-success">Active</span>
                          @endif
                        </td>
                        <td>
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit</button>
                          </a>
                        </td>
                        <td>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">
                              @if ($product -> is_archived)
                                Unarchive
                              @else
                                Archive
                              @endif
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
            <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
              @if (!$activeProducts -> count())
                <h4 class="d-flex justify-content-center">No products to show!</h4>
              @else
                <table class="table table-hover text-center align-middle">
                  <thead>
                    <tr>
                      <th>Stock Keeping Unit (SKU)</th>
                      <th>Product Name</th>
                      <th>Available Quantity</th>
                      <th>Product Status</th>
                      <th>Edit</th>
                      <th>Archive/Unarchive</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($activeProducts as $index => $product)
                      <tr>
                        <td>{{ $product -> sku }}</td>
                        <td>{{ $product -> name }}</td>
                        <td>{{ $product -> quantity }}</td>
                        <td>
                          @if ($product -> is_archived)
                            <span class="badge rounded-pill bg-danger">Archived</span>
                          @else
                            <span class="badge rounded-pill bg-success">Active</span>
                          @endif
                        </td>
                        <td>
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit</button>
                          </a>
                        </td>
                        <td>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">
                              @if ($product -> is_archived)
                                Unarchive
                              @else
                                Archive
                              @endif
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
            <div class="tab-pane fade" id="nav-archived" role="tabpanel" aria-labelledby="nav-archive-tab">
              @if (!$archivedProducts -> count())
                <h4 class="d-flex justify-content-center">No products to show!</h4>
              @else
                <table class="table table-hover text-center align-middle">
                  <thead>
                    <tr>
                      <th>Stock Keeping Unit (SKU)</th>
                      <th>Product Name</th>
                      <th>Available Quantity</th>
                      <th>Product Status</th>
                      <th>Edit</th>
                      <th>Archive/Unarchive</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($archivedProducts as $index => $product)
                      <tr>
                        <td>{{ $product -> sku }}</td>
                        <td>{{ $product -> name }}</td>
                        <td>{{ $product -> quantity }}</td>
                        <td>
                          @if ($product -> is_archived)
                            <span class="badge rounded-pill bg-danger">Archived</span>
                          @else
                            <span class="badge rounded-pill bg-success">Active</span>
                          @endif
                        </td>
                        <td>
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit</button>
                          </a>
                        </td>
                        <td>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">
                              @if ($product -> is_archived)
                                Unarchive
                              @else
                                Archive
                              @endif
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
          </div>
        </div>
      @else
        <div id="listicleDataView" class="mt-4">
          <nav>
            <div class="d-flex justify-content-evenly nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All Products</button>
              <button class="nav-link" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Active Products</button>
              <button class="nav-link" id="nav-archive-tab" data-bs-toggle="tab" data-bs-target="#nav-archived" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Archived Products</button>
            </div>
          </nav>
          <div class="tab-content mt-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
              <div class="accordion" id="allProductsAccordion">
                @if (!$allProducts -> count())
                  <h4 class="d-flex justify-content-center">No products to show!</h4>
                @endif
                @foreach ($allProducts as $index => $product)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageThumbnailContainer me-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        {{ $product -> name }} (<small>{{ $product -> sku }}</small>)
                      </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#allProductsAccordion">
                      <div class="accordion-body">
                        <div class="d-flex justify-content-end">
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit Product</button>
                          </a>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">
                              @if ($product -> is_archived)
                                Unarchive Product
                              @else
                                Archive Product
                              @endif
                            </button>
                          </form>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="skuInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="skuInput" name="skuInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="categoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="categoryInput" name="categoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productNameInput">Product Name</label>
                          <input type="text" class="form-control" id="productNameInput" name="productNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="productDescriptionInput" name="productDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="priceInput">Price per unit</label>
                          <input type="number" class="form-control" id="priceInput" name="priceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="unitInput">Item Unit</label>
                          <input type="text" class="form-control" id="unitInput" name="unitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="stockQuantityInput">Stock Quantity</label>
                          <input type="number" class="form-control" id="stockQuantityInput" name="stockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Product Status</label>
                          <br />
                          @if ($product -> is_archived)
                            <span class="badge rounded-pill bg-danger">Archived</span>
                          @else
                            <span class="badge rounded-pill bg-success">Active</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
              <div class="accordion" id="activeProductsAccordion">
                @if (!$activeProducts -> count())
                  <h4 class="d-flex justify-content-center">No products to show!</h4>
                @endif
                @foreach ($activeProducts as $index => $product)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageThumbnailContainer me-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        {{ $product -> name }} (<small>{{ $product -> sku }}</small>)
                      </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#activeProductsAccordion">
                      <div class="accordion-body">
                        <div class="d-flex justify-content-end">
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit Product</button>
                          </a>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">Archive Product</button>
                          </form>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="skuInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="skuInput" name="skuInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="categoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="categoryInput" name="categoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productNameInput">Product Name</label>
                          <input type="text" class="form-control" id="productNameInput" name="productNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="productDescriptionInput" name="productDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="priceInput">Price per unit</label>
                          <input type="text" class="form-control" id="priceInput" name="priceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="unitInput">Item Unit</label>
                          <input type="text" class="form-control" id="unitInput" name="unitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="stockQuantityInput">Stock Quantity</label>
                          <input type="text" class="form-control" id="stockQuantityInput" name="stockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="tab-pane fade" id="nav-archived" role="tabpanel" aria-labelledby="nav-archive-tab">
              <div class="accordion" id="archivedProductsAccordion">
                @if (!$archivedProducts -> count())
                  <h4 class="d-flex justify-content-center">No products to show!</h4>
                @endif
                @foreach ($archivedProducts as $index => $product)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageThumbnailContainer me-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        {{ $product -> name }} (<small>{{ $product -> sku }}</small>)
                      </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#archivedProductsAccordion">
                      <div class="accordion-body">
                        <div class="d-flex justify-content-end">
                          <a href="/inventory/product/{{ $product -> id }}" >
                            <button type="button" class="btn btn-warning">Edit Product</button>
                          </a>
                          <form method="POST" action="/inventory/product">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">Unarchive Product</button>
                          </form>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="skuInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="skuInput" name="skuInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="categoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="categoryInput" name="categoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productNameInput">Product Name</label>
                          <input type="text" class="form-control" id="productNameInput" name="productNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="productDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="productDescriptionInput" name="productDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="priceInput">Price per unit</label>
                          <input type="text" class="form-control" id="priceInput" name="priceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="unitInput">Item Unit</label>
                          <input type="text" class="form-control" id="unitInput" name="unitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="stockQuantityInput">Stock Quantity</label>
                          <input type="text" class="form-control" id="stockQuantityInput" name="stockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>
  </body>
</html>
