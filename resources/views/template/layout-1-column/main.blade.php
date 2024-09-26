<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="description" content="App">
    <meta name="keywords" content="App">
    <meta name="author" content="Muhammad Agung Mahardhika">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{--  --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    {{-- Datatable CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    {{-- Jquery --}}
    <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js') }}"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9d17737383.js" crossorigin="anonymous"></script>
    {{-- Swet Alert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- Icon materialize -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,200,0,0" />
    <!-- Gsap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>

    {{-- Datatable --}}
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- DateRangepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/daterangepicker/daterangepicker.css') }}">
    <!-- DateRangePicker JS -->
    <script src="{{ asset('assets/extensions/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/daterangepicker/daterangepicker.js') }}"></script>
    {{-- Costume js --}}
    <script src="{{ asset('assets/costume/app-costume.js') }}"></script>
    <title>aa</title>
</head>

<script>
    let baseUrl = '{{ url('') }}'
</script>

<body>
    <script src="assets/static/js/initTheme.js"></script>

    {{-- Main Content --}}
    <div class="page-content">
        @yield('container')
    </div>


    <script src="{{ asset('assets/static/js/components/dark.js') }} "></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }} "></script>
</body>

</html>
