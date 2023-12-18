
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    @if(session('error'))
    <script>
        Swal.fire('Error', '{{ session('error') }}', 'error');
    </script>
    @endif

     <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cart as $c)
                        <tr data-id="{{ $c->id }}">
                            @foreach ($c->product->asset as $a )
                            <td class="align-middle"><img src="{{ url('product/' . $a->file_name) }}" alt="" style="width: 50px;"> {{$c->product->product_name}}</td>
                            @endforeach
                            <td class="align-middle">Rp. {{number_format($c->product->price)}}</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    {{-- <div class="input-group-btn">
                                        <a href="/rmQty/{{$c->id}}" class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </a>
                                    </div> --}}
                                    {{-- <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{$c->qty}}"> --}}
                                    <input type="number" name="quantity" class="form-control form-control-sm bg-secondary text-center quantity" value="{{ $c->qty }}" data-productid="{{$c->product_id}}" data-rowid="{{ $c->id }}">
                                    <input type="hidden" name="product_id" value="{{$c->product_id}}">
                                    {{-- <div class="input-group-btn">
                                        <a href="/addQty/{{$c->id}}" class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div> --}}
                                </div>
                            </td>
                            <?php $total = $c->product->price * $c->qty?>
                            <td class="align-middle">Rp. {{number_format($total)}}</td>
                            <td class="align-middle actions">
                               <a href="/delete-cart/{{$c->id}}" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></a>
                               {{-- <button class="btn btn-sm btn-primary remove-from-cart"><i class="fa fa-trash"></i></button> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
            <form action="/checkouts" method="post" class="mb-5">
                @csrf
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">Rp. {{number_format($totalPrice->total_price)}}</h6>
                            <input type="hidden" name="total_price" value="{{$totalPrice->total_price}}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Tax</h6>
                            <h6 class="font-weight-medium">Rp. {{number_format($taxPrice)}}</h6>
                            <input type="hidden" name="tax_price" value="{{$taxPrice}}">
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">Rp. {{number_format($totalPrice->total_price + $taxPrice)}}</h5>
                            <input type="hidden" name="price_after_tax" value="{{$totalPrice->total_price + $taxPrice}}">
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Cart End -->


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
<script>
    $(document).ready(function() {
        $('.quantity').on('change', function() {
            var rowId = $(this).data('rowid');
            var productId = $(this).data('productid');
            var quantity = $(this).val();

            console.log(quantity);

            $.ajax({
                type: 'POST',
                url: `/cart-update/${rowId}/${productId}`,
                data: {
                    _token: '{{ csrf_token() }}',
                    rowId: rowId,
                    product_id: productId,
                    quantity: quantity
                },

                success: function(response) {
                    // Handle success - maybe update the UI or show a message
                    console.log(response);
                    location.reload()

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    if(aaaa){
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                    }
                }
            });
        });
    });
</script>

   @include('ecommerce.layout.script')
</body>

</html>
