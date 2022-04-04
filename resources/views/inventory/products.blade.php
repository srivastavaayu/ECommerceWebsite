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
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-3">Inventory - Products</h2>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
        <div class="d-flex justify-content-center">
          <a href="/inventory/product/add-new-product">
            <button type="button" class="btn btn-primary">Add New Product</button>
          </a>
        </div>

        <div class="d-flex justify-content-end">
          <form method="GET" action="/inventory/product">
            {{ csrf_field() }}
            <input type="hidden" name="sort" value="{{ $sortBehavior == 'ASC' ? 'DESC' : 'ASC' }}"></input>
            <button type="submit" class="btn btn-primary">Sort By: Date ({{ $sortBehavior == "ASC" ? "&uarr;" : "&darr;" }})</button>
          </form>
        </div>

        <div class="mt-4">
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
                          <label class="form-label" for="SKUInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="SKUInput" name="SKUInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="CategoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="CategoryInput" name="CategoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductNameInput">Product Name</label>
                          <input type="text" class="form-control" id="ProductNameInput" name="ProductNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="ProductDescriptionInput" name="ProductDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="PriceInput">Price per unit</label>
                          <input type="number" class="form-control" id="PriceInput" name="PriceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="UnitInput">Item Unit</label>
                          <input type="text" class="form-control" id="UnitInput" name="UnitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="StockQuantityInput">Stock Quantity</label>
                          <input type="number" class="form-control" id="StockQuantityInput" name="StockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
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
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">Archive Product</button>
                          </form>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="SKUInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="SKUInput" name="SKUInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="CategoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="CategoryInput" name="CategoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductNameInput">Product Name</label>
                          <input type="text" class="form-control" id="ProductNameInput" name="ProductNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="ProductDescriptionInput" name="ProductDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="PriceInput">Price per unit</label>
                          <input type="text" class="form-control" id="PriceInput" name="PriceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="UnitInput">Item Unit</label>
                          <input type="text" class="form-control" id="UnitInput" name="UnitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="StockQuantityInput">Stock Quantity</label>
                          <input type="text" class="form-control" id="StockQuantityInput" name="StockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
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
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger ms-2" name="productId" value="{{ $product -> id }}">Unarchive Product</button>
                          </form>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="SKUInput">Stock Keeping Unit (SKU)</label>
                          <input type="text" class="form-control" id="SKUInput" name="SKUInput" value="{{ $product -> sku }}" placeholder="{{ $product -> sku }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="CategoryInput">Category</label>
                          @foreach ($categories as $category)
                            @if (($category -> id) == ($product -> category_id))
                              <input type="text" class="form-control" id="CategoryInput" name="CategoryInput" value="{{ $category -> name }}" placeholder="{{ $category -> name }}" readonly>
                            @endif
                          @endforeach
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductNameInput">Product Name</label>
                          <input type="text" class="form-control" id="ProductNameInput" name="ProductNameInput" value="{{ $product -> name }}" placeholder="{{ $product -> name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="ProductDescriptionInput">Product Description</label>
                          <textarea class="form-control" id="ProductDescriptionInput" name="ProductDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh" readonly>{{ $product -> description }}</textarea>
                        </div>
                        <label class="form-label">Product Images</label>
                        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
                          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
                        @endif
                        <div class="mb-3">
                          <label class="form-label" for="PriceInput">Price per unit</label>
                          <input type="text" class="form-control" id="PriceInput" name="PriceInput" value="{{ $product -> price }}" placeholder="{{ $product -> price }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="UnitInput">Item Unit</label>
                          <input type="text" class="form-control" id="UnitInput" name="UnitInput" value="{{ $product -> unit }}" placeholder="{{ $product -> unit }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="StockQuantityInput">Stock Quantity</label>
                          <input type="text" class="form-control" id="StockQuantityInput" name="StockQuantityInput" value="{{ $product -> quantity }}" placeholder="{{ $product -> quantity }}" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
