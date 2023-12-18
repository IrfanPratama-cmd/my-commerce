<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        @foreach ($brand as $b)
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">{{$b->product_count}} Products</p>
                    <a href="" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="https://source.unsplash.com/1200x900/?{{ $b->brand_name }}" alt="">
                    </a>
                    <h5 class="font-weight-semi-bold m-0">{{$b->brand_name}}</h5>
                </div>
            </div>
        @endforeach
    </div>
</div>
