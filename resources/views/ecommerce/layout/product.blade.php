<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Our Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($product as $p )
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        @foreach ($p->asset as $asset )
                            <img class="img-fluid" style="width: 300px; height: 280px;" src="{{ url('product/' . $asset->file_name) }}" alt="">
                            <?php break ?>
                        @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$p->product_name}}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>Rp. {{number_format($p->price)}}</h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="/detail-product/{{$p->id}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="/add-to-cart/{{$p->id}}" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>
