
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Profile</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Profile</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


     <!-- Contact Start -->
     <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">My Profile</span></h2>
        </div><br>
        <div class="row px-xl-5">
            <div class="col-lg-6 px-5 d-flex justify-content-center">
                @if ($profile->profile_asset)
                    <img src="{{ url('profile/' . $profile->profile_asset) }}" style="width: 300px; height: 400px;" class="img-preview img-fluid ">
                @else
                    <img src="{{ url('asset/user.png') }}" style="width: 200px; height: 200px;" class="img-preview img-fluid">
                @endif
            </div>
            <div class="col-lg-6 mb-5">
                <div class="contact-form">
                    <form action="/update-profile" method="post" class="mb-5" enctype="multipart/form-data">
                        @csrf
                        <div class="control-group">
                            <label for="name">Fullname</label>
                            <input type="text" class="form-control" id="name" name="full_name"
                               value="{{$profile->full_name}}" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{$profile->user->email}}" disabled />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control" name="phone_number" id="phone" value="{{$profile->phone_number}}" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="3" name="address" id="message" placeholder="Message"
                                required="required"
                                value="{{$profile->adress}}" >{{$profile->address}}</textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="asset" class="form-label">Profile Image</label>
                            <input type="hidden" name="oldImage" value="{{ $profile->profile_asset }}">
                            <input class="form-control @error('asset') is-invalid @enderror" type="file" id="image" name="asset"
                            onchange="previewImage()">
                            @error('asset')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
   @include('ecommerce.layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <script>

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
            }
        }
        </script>


   @include('ecommerce.layout.script')
</body>

</html>
