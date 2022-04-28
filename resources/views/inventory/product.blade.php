@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>EComWeb - Inventory - Edit Product ({{ $product -> sku }})</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link href="../../css/general.css" rel="stylesheet">
      <link href="../../css/inventory.css" rel="stylesheet">
  </head>
  <body>
    <div class="backgroundImage"></div>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <div class="modal fade" id="addNewCategoryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="AddNewCategoryForm" method="POST" action="/inventory/product/new-product">
              {{ csrf_field() }}
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="CategoryNameInput" name="CategoryNameInput" placeholder="Category Name" value="{{ old('CategoryNameInput') }}" required>
                <label for="CategoryNameInput">Category Name*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="CategoryDescriptionInput" name="CategoryDescriptionInput" placeholder="Category Description" value="{{ old('CategoryDescriptionInput') }}" required>
                <label for="CategoryDescriptionInput">Category Description*</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="action" value="AddNewCategory" form="AddNewCategoryForm">Add New Category</button>
          </div>
        </div>
      </div>
    </div>

    <main class="main container-fluid mt-3 mb-5" style="width: 70%">
      <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
      <h2 class="text-center mb-3">Inventory - Edit Product ({{ $product -> sku }})</h2>
      <div style="color: blue; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div style="color: blue; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
          @break
        @endforeach
      @endif

      <div class="d-flex justify-content-end">
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
      <form method="POST" enctype="multipart/form-data" action="/inventory/product/{{ $product -> id }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <label class="form-label" for="categoryInput">Category*</label>
        <div class="input-group mb-3">
          <select class="form-select" id="categoryInput" name="categoryInput" placeholder="{{ $product -> category_id }}" value="{{ old('categoryInput') }}">
            <option value="" disabled>Please select an option</option>
            @if (isset($categories))
              @foreach ($categories as $category)
                @if (($category -> id) == ($product -> category_id))
                  <option value="{{ $category -> id }}" selected>{{ $category -> name }}</option>
                @else
                  <option value="{{ $category -> id }}">{{ $category -> name }}</option>
                @endif
              @endforeach
            @endif
          </select>
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNewCategoryModal">
            Add New Category
          </button>
        </div>
        <div class="mb-3">
          <label class="form-label" for="skuInput">Stock Keeping Unit (SKU)*</label>
          <input type="text" class="form-control" id="skuInput" name="skuInput" placeholder="{{ $product -> sku }}" value="{{ old('skuInput') }}">
        </div>
        <div class="mb-3">
          <label class="form-label" for="productNameInput">Product Name*</label>
          <input type="text" class="form-control" id="productNameInput" name="productNameInput" placeholder="{{ $product -> name }}" value="{{ old('productNameInput') }}">
        </div>
        <div class="mb-3">
          <label class="form-label" for="productDescriptionInput">Product Description*</label>
          <textarea class="form-control" id="productDescriptionInput" name="productDescriptionInput" placeholder="{{ $product -> description }}" style="height: 50vh">{{ old('productDescriptionInput') }}</textarea>
        </div>
        <label class="form-label">Current Product Images</label>
        @if (!is_null($product -> image_path) && ($product -> image_path != ""))
          <div class="productImageContainer mb-3"><img src="{{ asset(Storage::url($product -> image_path)) }}" style="object-fit: contain; height: 100%;"/></div>
        @endif
        <div class="mt-3 mb-3">
          <label for="productImageInput" class="form-label">Product Image</label>
          <input type="file" class="form-control" id="productImageInput" name="productImageInput">
        </div>
        <div class="mb-3">
          <label class="form-label" for="priceInput">Price per unit*</label>
          <input type="number" class="form-control" id="priceInput" name="priceInput" placeholder="{{ $product -> price }}" value="{{ old('priceInput') }}" pattern="[0-9]+" min="1">
        </div>
        <div class="mb-3">
          <label class="form-label" for="unitInput">Item Unit*</label>
          <input type="text" class="form-control" id="unitInput" name="unitInput" placeholder="{{ $product -> unit }}" value="{{ old('unitInput') }}">
        </div>
        <div class="mb-3">
          <label class="form-label" for="stockQuantityInput">Stock Quantity*</label>
          <input type="number" class="form-control" id="stockQuantityInput" name="stockQuantityInput" placeholder="{{ $product -> quantity }}" value="{{ old('stockQuantityInput') }}" min="1">
        </div>
        <div class="d-flex justify-content-end">
          <a href="/inventory/product"><button type="button" class="btn btn-danger">Cancel</button></a>
          <button type="submit" class="btn btn-success ms-2">Update Product</button>
        </div>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
    </script>
  </body>
</html>
