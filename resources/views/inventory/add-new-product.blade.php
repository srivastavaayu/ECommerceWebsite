@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EComWeb - Inventory - Add New Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../../css/general.css" rel="stylesheet">
  </head>
  <body>
    @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
    <div class="modal fade" id="addNewCategoryModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="AddNewCategoryForm" method="POST" action="/inventory/product/add-new-product">
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
      <h2 class="text-center mb-3">Inventory - Add New Product</h2>
      <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-5 mt-3">{{ isset($info) ? $info : "" }}</div>
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
          @break
        @endforeach
      @endif

      <form method="POST" enctype="multipart/form-data" action="/inventory/product/add-new-product">
        {{ csrf_field() }}
        <div class="input-group form-floating mb-3">
          <select class="form-select" id="CategoryInput" name="CategoryInput" placeholder="Category" value="{{ old('CategoryInput') }}" required>
            <option value="" selected disabled>Please select an option</option>
            @if (isset($categories))
              @foreach ($categories as $category)
                <option value="{{ $category -> id }}">{{ $category -> name }}</option>
              @endforeach
            @endif
          </select>
          <label for="CategoryInput">Category*</label>
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNewCategoryModal">
            Add New Category
          </button>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="SKUInput" name="SKUInput" placeholder="Stock Keeping Unit (SKU)" value="{{ old('SKUInput') }}" required>
          <label for="SKUInput">Stock Keeping Unit (SKU)*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="ProductNameInput" name="ProductNameInput" placeholder="Product Name" value="{{ old('ProductNameInput') }}" required>
          <label for="ProductNameInput">Product Name*</label>
        </div>
        <div class="form-floating mb-3">
          <textarea class="form-control" id="ProductDescriptionInput" name="ProductDescriptionInput" placeholder="Product Description" style="height: 50vh" required>{{ old('ProductDescriptionInput') }}</textarea>
          <label for="ProductDescriptionInput">Product Description*</label>
        </div>
        <div class="mt-3 mb-3">
          <label for="ProductImageInput" class="form-label">Product Image</label>
          <input type="file" class="form-control" id="ProductImageInput" name="ProductImageInput">
        </div>
        <div class="form-floating mb-3">
          <input type="number" class="form-control" id="PriceInput" name="PriceInput" placeholder="Price per unit" value="{{ old('PriceInput') }}" pattern="[0-9]+" min="1" required>
          <label for="PriceInput">Price per unit*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="UnitInput" name="UnitInput" placeholder="Item Unit" value="{{ old('UnitInput') }}" required>
          <label for="UnitInput">Item Unit*</label>
        </div>
        <div class="form-floating mb-3">
          <input type="number" class="form-control" id="StockQuantityInput" name="StockQuantityInput" placeholder="Stock Quantity" value="{{ old('StockQuantityInput') }}" min="1" required>
          <label for="StockQuantityInput">Stock Quantity*</label>
        </div>
        <br />
        <div class="d-flex justify-content-end">
          <a href="/inventory/product" >
            <button type="button" class="btn btn-primary">Cancel</button>
          </a>
          <button type="submit" class="btn btn-success ms-2">Add Product to Inventory</button>
        </div>
      </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
