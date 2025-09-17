<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Tabletray' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">



    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('webasset/assets/img/favicon/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">


    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/fonts/iconify-icons.css') }}">

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/node-waves/node-waves.css') }}">


    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/pickr/pickr-themes.css') }}">

    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('webasset/assets/css/demo.css') }}">


    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('webasset/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

    <!-- Page CSS -->


    <!-- Helpers -->
    <script src="{{ asset('webasset/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('webasset/assets/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('webasset/assets/js/config.js') }}"></script>




    <!-- Head section me -->
    @livewireStyles
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <x-navbar />


    <!-- Mobile Sidebar (Offcanvas) -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">🧠 Admin Panel</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            @include('components.sidebar')
        </div>
    </div>

    <!-- Page Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Desktop Sidebar (Fixed) -->
            <div class="d-none d-md-block">
                <div class="sidebar-fixed">
                    <x-sidebar />
                </div>
            </div>

            <!-- Main Content -->
            <div class="col px-0">
                <div class="content-area">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
