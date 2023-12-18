<div class="row border-top px-xl-5">
    <div class="col-lg-3 d-none d-lg-block">
        <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
            <h6 class="m-0">Categories</h6>
            <i class="fa fa-angle-down text-dark"></i>
        </a>
        <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
            <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                @foreach ($category as $c)
                        <form action="/get-products" method="get" class="form-inline my-2 my-lg-0">
                            <input type="submit" style="width: 100%; text-align: left;" class="btn btn-link nav-link" name="filter[category.category_name]" value="{{$c->category_name}}">
                        </form>
                @endforeach
            </div>
        </nav>
    </div>
    <div class="col-lg-9">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
            <a href="" class="text-decoration-none d-block d-lg-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="/" class="nav-item nav-link">Home</a>
                    <a href="/get-products" class="nav-item nav-link">Product</a>
                    <a href="/carts" class="nav-item nav-link">Shopping Cart</a>
                    <a href="/checkouts" class="nav-item nav-link">Checkout</a>
                    <a href="/user-profile" class="nav-item nav-link">Profile</a>
                    @can('read-dashboard')
                    <a href="/dashboard" class="nav-item nav-link">Dashboard</a>
                    @endcan
                    <a href="/user-transactions" class="nav-item nav-link">Transaction</a>
                </div>
                <div class="navbar-nav ml-auto py-0">
                    @auth()
                    <a href="/logout" class="nav-item nav-link">Log Out</a>
                    @else
                    <a href="/login" class="nav-item nav-link">Login</a>
                    <a href="/register" class="nav-item nav-link">Register</a>
                    @endauth

                </div>
            </div>
        </nav>
    </div>
</div>

