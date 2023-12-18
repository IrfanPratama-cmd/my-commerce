
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


    <!-- Categories Start -->
    @include('ecommerce.layout.categories')
    <!-- Categories End -->


    <!-- Offer Start -->
    @include('ecommerce.layout.offer')
    <!-- Offer End -->


    <!-- Products Start -->
    @include('ecommerce.layout.product')
    <!-- Products End -->




    <!-- Footer Start -->
    @include('ecommerce.layout.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    @include('ecommerce.layout.script')
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
</body>

</html>
