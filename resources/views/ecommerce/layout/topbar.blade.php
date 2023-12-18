<div class="container-fluid">

<div class="row align-items-center py-3 px-xl-5">
    <div class="col-lg-3 d-none d-lg-block">
        <a href="" class="text-decoration-none">
            <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
        </a>
    </div>
    <div class="col-lg-6 col-6 text-left">
        <form action="/get-products" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="filter[product_name]" placeholder="Search for products">
                <div class="input-group-append">
                    <span class="input-group-text bg-transparent text-primary">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-3 col-6 text-right">
        <a href="" class="btn border">
            <i class="fas fa-heart text-primary"></i>
            <span class="badge">0</span>
        </a>
        <a href="/carts" class="btn border" >
            <i class="fas fa-shopping-cart text-primary"></i>
            <span class="badge" id="app"></span>
        </a>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Make an Axios GET request to fetch data
    axios.get('/count-carts')
        .then(response => {
            // Handle the successful response and update the DOM
            document.getElementById('app').innerHTML += `${response.data.total}`
        })
        .catch(error => {
            // Handle any errors
            console.error('Error fetching data:', error);
        });
</script>
