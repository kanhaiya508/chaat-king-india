<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Tabletray' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('panel/assets/img/favicon/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">


    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/fonts/iconify-icons.css') }}">

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/node-waves/node-waves.css') }}">


    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/pickr/pickr-themes.css') }}">

    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/assets/css/demo.css') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('panel/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">

    <!-- Page CSS -->


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />


    <!-- Helpers -->
    <script src="{{ asset('panel/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('panel/assets/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('panel/assets/js/config.js') }}"></script>


    <link rel="stylesheet" href="{{ asset('panel/assets/vendor/libs/spinkit/spinkit.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Head section me -->
    @livewireStyles
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">


            <x-navbar />

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <x-sidebar />

                    {{ $slot }}


                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme border-top">
                        <div class="container-xxl py-4">
                            <div class="row align-items-center">
                                <!-- Left Text -->
                                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0 text-body">
                                    &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    Powered by <strong>Ansdesk</strong>, All rights reserved.

                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->


                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->


    <script src="{{ asset('panel/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('panel/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('panel/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('panel/assets/vendor/libs/node-waves/node-waves.js') }}"></script>



    <script src="{{ asset('panel/assets/vendor/libs/%40algolia/autocomplete-js.js') }}"></script>

    <script src="{{ asset('panel/assets/vendor/libs/pickr/pickr.js') }}"></script>



    <script src="{{ asset('panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


    <script src="{{ asset('panel/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('panel/assets/vendor/libs/i18n/i18n.js') }}"></script>


    <script src="{{ asset('panel/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('panel/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('panel/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('panel/assets/js/main.js') }}"></script>


    <!-- Page JS -->
    <script src="{{ asset('panel/assets/js/app-ecommerce-dashboard.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
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
                    position: 'bottom-end',
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".js-example-basic-multiple-limit").select2({
                placeholder: "Select ",
                allowClear: true
            });
        });
    </script>

</body>

</html>
