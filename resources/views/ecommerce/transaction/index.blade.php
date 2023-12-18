
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Transaction</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Transaction</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container">
        <div class="row">
                <div class="col-xl-12 ">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                  <tr class="table-primary">
                                    <th scope="col">Date</th>
                                    <th scope="col">Transaction Code</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Detail</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($transaction as $t)
                                    <tr>
                                        <td>{{$t->transaction_time}}</td>
                                        <td>{{$t->transaction_code}}</td>
                                        <td>{{$t->transaction_status}}</td>
                                        <td>Rp. {{number_format($t->price_after_tax)}}</td>
                                        <td><a href="/invoice/{{$t->id}}" class="btn btn-primary">Detail</a></td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
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
