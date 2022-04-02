@include('../header')

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EComWeb - Checkout</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../css/general.css" rel="stylesheet">
        <link href="../css/checkout.css" rel="stylesheet">
    </head>
    <body>
      @yield(Auth::check() ? "RegisteredUserHeader" : "GuestUserHeader")
      <main class="main container-fluid mt-3 mb-5" style="width: 95%">
        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">&larr; Back</button></a>
        <h2 class="text-center mb-5">Checkout</h2>
        <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ isset($info) ? $info : "" }}</div>
        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div style="color: orange; font-weight: 500; font-size: 1rem" class="text-center mb-3 mt-3">{{ $error }}</div>
            @break
          @endforeach
        @endif

        <div class="checkoutContainer">
          <div>
            <h3 class="text-center">Your Information</h3>
            <form id="checkoutForm" method="POST" action="/checkout/checkout">
              {{ csrf_field() }}
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="FullNameInput" name="FullNameInput" placeholder="Full Name" value="{{ $user -> name }}" readonly>
                <label for="FullNameInput">Full Name*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="EmailInput" name="EmailInput" placeholder="Email" value="{{ $user -> email }}" readonly>
                <label for="EmailInput">Email Address*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="PhoneNumberInput" name="PhoneNumberInput" placeholder="Phone Number" value="{{ $user -> phone_number }}" readonly>
                <label for="PhoneNumberInput">Phone Number*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="AddressLine1Input" name="AddressLine1Input" placeholder="Address Line 1" value="{{ old('AddressLine1Input') }}" required>
                <label for="AddressLine1Input">Address Line 1*</label>
              </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="AddressLine2Input" name="AddressLine2Input" placeholder="Address Line 2" value="{{ old('AddressLine2Input') }}" required>
                <label for="AddressLine2Input">Address Line 2*</label>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="CityInput" name="CityInput" placeholder="City" value="{{ old('CityInput') }}" pattern="[A-Za-z0-9 ]+" required>
                    <label for="CityInput">City*</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="StateInput" name="StateInput" placeholder="State" value="{{ old('StateInput') }}" pattern="[A-Za-z0-9 ]+" required>
                    <label for="StateInput">State*</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="CountryInput" name="CountryInput" placeholder="Country" value="{{ old('CountryInput') }}" pattern="[A-Za-z0-9 ]+" required>
                    <label for="CountryInput">Country*</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="PINCodeInput" name="PINCodeInput" placeholder="PIN Code" value="{{ old('PINCodeInput') }}" pattern="[0-9]{6}" required>
                    <label for="PINCodeInput">PIN Code*</label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div>
            <h3 class="text-center">Cart Summary</h3>
            <div class="cartProductsContainer">
              @foreach ($products as $product)
                <a href="/shop/product/{{ $product -> id }}" class="cartProductContainerLink">
                  <div class="cartProductContainer">
                    <div></div>
                    <div>
                      <h4>{{ $product -> name }}</h4>
                      <p>{{ $product -> description }}</p>
                      @foreach ($cart as $cartItem)
                        @if ($cartItem -> product_id == $product -> id)
                          <span class="fw-bold" style="font-size: 1.2em">{{ $product -> price * $cartItem -> quantity }}</span>
                          <small>{{ $product -> price }} x {{ $cartItem -> quantity }}</small>
                        @endif
                      @endforeach
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
            <div class="cartTotalsContainer mt-2">
              <table class="table table-hover mb-0">
                  <tr>
                    <th>Sub-Total Amount:</th>
                    <td class="text-end">{{ $cartTotal }}</td>
                  </tr>
                  <tr>
                    <th>Total Amount:</th>
                    <td class="text-end">{{ $cartTotal }}</td>
                  </tr>
                  <tr>
                    <th>To Pay:</th>
                    <td class="text-end">{{ $cartTotal }}</td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="d-grid gap-2 mt-3">
          <button class="btn btn-success btn-lg" type="submit" form="checkoutForm">Proceed to Pay (<small>Pay {{ $cartTotal }}</small>)</button>
          <a href="/" class="btn btn-danger" type="button">Cancel</a>
        </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
