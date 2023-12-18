
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
            <div class="col-lg-6 pl-5 d-flex justify-content-center">
                @if ($profile->profile_asset)
                    <img src="{{ url('profile/' . $profile->profile_asset) }}" style="width: 400px; height: 400px;" class="rounded-circle">
                @else
                    <img src="{{ url('asset/user.png') }}" style="width: 300px; height: 300px;" class="img-preview img-fluid">
                @endif
            </div>
            <div class="col-lg-6 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form >
                        <div class="control-group">
                            <label for="name">Fullname</label>
                            <input type="text" class="form-control" id="name"
                               value="{{$profile->full_name}}" disabled/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{$profile->user->email}}" disabled />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control" id="phone" value="{{$profile->phone_number}}"disabled />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="6" id="message"
                                required="required"
                                disabled>{{$profile->address}}</textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <a href="/edit-profile" class="btn btn-primary">Edit Profile</a>
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


   @include('ecommerce.layout.script')
</body>

</html>
