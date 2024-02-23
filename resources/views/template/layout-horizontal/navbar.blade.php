<style type="text/css">
    /* ============ only desktop view ============ */
    @media all and (min-width: 992px) {
        .navbar .nav-item .dropdown-menu {
            display: block;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
            margin-top: 0;
        }

        .navbar .nav-item:hover .nav-link {
            color: #ffff;
        }

        .navbar .dropdown-menu {
            top: 80%;
            transform: rotateX(-75deg);
            transform-origin: 0% 0%;
        }

        .navbar .dropdown-menu.fade-up {
            top: 180%;
        }

        .navbar .nav-item:hover .dropdown-menu {
            transition: .3s;
            opacity: 1;
            visibility: visible;
            top: 100%;
            transform: rotateX(0deg);
        }

    }

    /* ============ desktop view .end// ============ */
</style>
<!-- Awal navigasi -->
<nav class="navbar navbar-expand-lg navbar-light position-fixed shadow-sm bg-white" style="z-index: 999; right:0;left:0;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex justify-content-center" href="{{ URL::to('index.php') }}">
            <img src="{{ URL::to('images/LOGO-POKDARWIS.png') }}" class="rounded" width="50">
            <span class="display-6 ms-2 text-success" style="font-family: 'Stick No Bills', sans-serif;">BATU
                BUSUK</span>
        </a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav ms-auto me-4 rounded" style="font-family: 'Stick No Bills', sans-serif;">
                <li class="nav-item active"><a class="nav-link text-dark" href="{{ URL::to('/') }}"> BERANDA </a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown"> PARIWISATA
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ URL::to('atractions') }}"> Atraksi </a></li>
                        <li><a class="dropdown-item" href="{{ URL::to('events') }}"> Event </a></li>
                        <li><a class="dropdown-item" href="hkm"> Hkm </a></li>
                    </ul>
                </li>
                <li class="nav-item active"><a class="nav-link text-dark" href="{{ URL::to('packages') }}"> PAKET
                        WISATA</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown"> PRODUK </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ URL::to('products/product') }}"> Produk Olahan </a></li>
                        <li><a class="dropdown-item" href="{{ URL::to('products/culinary') }}"> Kuliner </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">
                        AKOMODASI</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ URL::to('transport') }}"> Transportasi </a></li>
                        <li><a class="dropdown-item" href="{{ URL::to('accomodation') }}"> Penginapan</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link text-dark" href="kontak.php"> SEJARAH DAN KEBUDAYAAN </a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="kontak.php"> KONTAK </a></li>
            </ul>
        </div>
    </div>
</nav>
