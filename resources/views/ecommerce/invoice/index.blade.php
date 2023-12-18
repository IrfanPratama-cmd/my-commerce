
<!DOCTYPE html>
<html lang="en">

<head>
   @include('ecommerce.layout.header')
   <link rel="stylesheet" type="text/css" href="/css/invoice.css">
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Invoice</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Invoice</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container">
        <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="invoice-container">
                                <div class="invoice-header">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="custom-actions-btns mb-5">
                                                <a href="#" class="btn btn-primary">
                                                    <i class="icon-download"></i> Download
                                                </a>
                                                <a href="#" class="btn btn-secondary">
                                                    <i class="icon-printer"></i> Print
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <a href="index.html" class="invoice-logo">
                                                UrStore.com
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <address class="text-right">
                                                Ngroto, Peleman RT 01 RW 01<br>
                                                Gemolong, Sragen<br>
                                                57274
                                            </address>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                            <div class="invoice-details">
                                                <address>
                                                    {{$profile->full_name}}<br>
                                                    {{$profile->address}}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                            <div class="invoice-details">
                                                <div class="invoice-num">
                                                    <div>Invoice - {{$transaction->transaction_code}}</div>
                                                    <div>{{$transaction->transaction_time}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>
                                <div class="invoice-body">
                                    <!-- Row start -->
                                    <div class="row gutters">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table custom-table m-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Items</th>
                                                            <th>Product ID</th>
                                                            <th>Quantity</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($checkout as $c)
                                                        <tr>
                                                            <td>
                                                                {{$c->product_name}}
                                                            </td>
                                                            <td>{{$c->product_code}}</td>
                                                            <td>{{$c->qty}}</td>
                                                            <td>{{number_format($c->total_price)}}</td>
                                                        </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2">
                                                                <p>
                                                                    Subtotal<br>
                                                                    Tax<br>
                                                                </p>
                                                                <h5 class="text-success"><strong>Grand Total</strong></h5>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    Rp. {{number_format($transaction->total_price)}}<br>
                                                                    Rp. {{number_format($transaction->total_tax)}}<br>
                                                                </p>
                                                                <h5 class="text-success"><strong>Rp. {{number_format($transaction->price_after_tax)}}</strong></h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row end -->
                                </div>
                                <div class="invoice-footer">
                                    Thank you for your Business.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Footer Start -->
   @include('ecommerce.layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   @include('ecommerce.layout.script')
</body>

</html>
