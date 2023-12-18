
<!DOCTYPE html>
<html lang="en">

<head>
   @include('ecommerce.layout.header')
</head>

<body>
    <!-- Topbar Start -->
    @include('ecommerce.layout.topbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
     @include('ecommerce.detail.navbar')
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">checkOut</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">checkOut</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    @if(session('error'))
    <script>
        Swal.fire('Error', '{{ session('error') }}', 'error');
    </script>
    @endif

     <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Full Name</label>
                            <input class="form-control" type="text" name="full_name" value="{{$profile->full_name}}" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" name="email" value="{{$profile->user->email}}" readonly>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phone Number</label>
                            <input class="form-control" type="text" name="phone_number" value="{{$profile->phone_number}}" readonly>
                        </div>
                        <input type="hidden" name="address" value="{{$profile->address}}">
                        <div class="col-md-6 form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="3" id="message" name="address"
                                required="required"
                                disabled>{{$profile->address}}</textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="col-md-12 form-group">
                            <a href="/edit-profile" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @foreach ($checkout as $c)
                        <div class="d-flex justify-content-between">
                            <p>{{$c->product_name}}</p>
                            <p>Rp. {{number_format($c->total_price)}}</p>
                        </div>
                        @endforeach
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">Rp. {{number_format($transaction->total_price)}}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Tax Prie</h6>
                            <h6 class="font-weight-medium">Rp. {{number_format($transaction->total_tax)}}</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rp. {{number_format($transaction->price_after_tax)}}</h5>
                        </div>
                    </div>
                    <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
                    <input type="hidden" name="gross_amount" value="{{$transaction->price_after_tax}}">
                    <button class="btn btn-block btn-primary my-3 py-3" id="pay-button">Proceed To Pay</button>
                    <a href="/cancel-transaction" class="btn btn-block btn-danger my-1 py-3">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->



    <!-- Footer Start -->
   @include('ecommerce.layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script>

        @if (session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        })
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
        })
        @endif

        @if (session('error'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        })
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
        })
        @endif

    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();

        snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                window.location.href = 'invoice/{{$transaction->id}}'
                console.log(result)
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)
            }
        });
    });
</script>

   @include('ecommerce.layout.script')
</body>

</html>
