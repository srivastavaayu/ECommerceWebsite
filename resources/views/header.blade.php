@section('RegisteredUserHeader')
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">&lt; EComWeb /&gt;</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMenu">
        <form class="d-flex ms-auto" method="GET" action="/shop/search">
          {{ csrf_field() }}
          <input class="form-control me-2" name="term" type="search" placeholder="Search for categories or products" aria-label="Search for categories or products">
          <button class="btn btn-outline-success" type="submit">Go!</button>
        </form>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarCategoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Shop by category
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarCategoryDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li> -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarShopByDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Shop by
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarShopByDropdown">
              <li><a class="dropdown-item" href="/shop/category">Category</a></li>
              <li><a class="dropdown-item" href="/shop/product">Product</a></li>
            </ul>
          </li> -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarBuyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Buy
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarBuyDropdown">
              <li><a class="dropdown-item" href="/shop/search">Search</a></li>
              <li><a class="dropdown-item" href="/shop/category">Categories</a></li>
              <li><a class="dropdown-item" href="/shop/product">Products</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/checkout/cart">Cart</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarSellDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Sell
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarSellDropdown">
              <li><a class="dropdown-item" href="/inventory/product">Products</a></li>
              <li><a class="dropdown-item" href="/inventory/warehouse">Warehouses</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              My Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfileDropdown">
              <li><a class="dropdown-item" href="/user/profile">Profile</a></li>
              <li><a class="dropdown-item" href="/user/orders-history">Orders History</a></li>
              <!-- <li><a class="dropdown-item" href="/user/saved-address">Saved Addresses</a></li> -->
              <li><a class="dropdown-item" href="/user/update-password">Update Password</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
@endsection

@section('GuestUserHeader')
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">&lt; EComWeb /&gt;</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMenu">
        <form class="d-flex ms-auto" method="GET" action="/shop/search">
          {{ csrf_field() }}
          <input class="form-control me-2" name="term" type="search" placeholder="Search for categories or products" aria-label="Search for categories or products">
          <button class="btn btn-outline-success" type="submit">Go!</button>
        </form>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
@endsection