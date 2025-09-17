<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Tabletray' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Head section me -->
    @livewireStyles

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playball&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('webasset/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('webasset/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('webasset/lib/owlcarousel/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('webasset/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('webasset/css/style.css') }}" rel="stylesheet">

</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid nav-bar">
        <div class="container">
            <nav class="navbar navbar-light navbar-expand-lg py-4">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary fw-bold mb-0">Cater<span class="text-dark">Serv</span> </h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ route('index') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ route('about') }}" class="nav-item nav-link">About</a>
                        <a href="{{ route('service') }}" class="nav-item nav-link">Services</a>
                        <a href="{{ route('menu') }}" class="nav-item nav-link">Menu</a>
                        <a href="{{ route('gallery') }}" class="nav-item nav-link">Gallery</a>
                        <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
                    </div>

                    <a href="{{ route('contact') }}"
                        class="btn btn-primary py-2 px-4 d-none d-xl-inline-block rounded-pill">Book
                        Now</a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control bg-transparent p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->
    @yield('website')

    <!-- Footer Start -->
    <div class="container-fluid footer py-6 my-6 mb-0 bg-light wow bounceInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h1 class="text-primary">Cater<span class="text-dark">Serv</span></h1>
                        <p class="lh-lg mb-4">There cursus massa at urnaaculis estieSed aliquamellus vitae ultrs
                            condmentum leo massamollis its estiegittis miristum.</p>
                        <div class="footer-icon d-flex">
                            <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square me-2 rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-primary btn-sm-square me-2 rounded-circle"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-primary btn-sm-square rounded-circle"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="mb-4">Special Facilities</h4>
                        <div class="d-flex flex-column align-items-start">
                            <a class="text-body mb-3" href=""><i
                                    class="fa fa-check text-primary me-2"></i>Cheese Burger</a>
                            <a class="text-body mb-3" href=""><i
                                    class="fa fa-check text-primary me-2"></i>Sandwich</a>
                            <a class="text-body mb-3" href=""><i
                                    class="fa fa-check text-primary me-2"></i>Panner Burger</a>
                            <a class="text-body mb-3" href=""><i
                                    class="fa fa-check text-primary me-2"></i>Special Sweets</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="mb-4">Contact Us</h4>
                        <div class="d-flex flex-column align-items-start">
                            <p><i class="fa fa-map-marker-alt text-primary me-2"></i> 123 Street, New York, USA</p>
                            <p><i class="fa fa-phone-alt text-primary me-2"></i> (+012) 3456 7890 123</p>
                            <p><i class="fas fa-envelope text-primary me-2"></i> info@example.com</p>
                            <p><i class="fa fa-clock text-primary me-2"></i> 26/7 Hours Service</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="mb-4">Social Gallery</h4>
                        <div class="row g-2">
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-01.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-02.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-03.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-04.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-05.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ asset('webasset/img/menu-06.jpg') }}"
                                    class="img-fluid rounded-circle border border-primary p-2" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i
                                class="fas fa-copyright text-light me-2"></i>Powered by
                            Ansdesk </a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">

                    Build by <a class="border-bottom" target="_blank" href="https://webdeveloperkashi.com/">Web
                        Developer Kashi</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-md-square btn-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('webasset/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('webasset/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('webasset/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('webasset/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('webasset/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('webasset/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('webasset/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Body ke end me -->
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-toast', (message) => {
                console.log("Toast message received:", message); // Debug
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: message ?? 'Something happened!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#d4edda',
                    color: '#155724',
                    iconColor: '#155724',
                });
            });
        });
    </script>
</body>

</html>
