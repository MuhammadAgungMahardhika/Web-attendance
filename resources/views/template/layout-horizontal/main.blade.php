<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="description" content="App">
    <meta name="keywords" content="App">
    <meta name="author" content="Muhammad Agung Mahardhika">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ url('images/LOGO-POKDARWIS.png') }}">

    {{--  --}}
    <link rel="shortcut icon" href="{{ asset('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9d17737383.js" crossorigin="anonymous"></script>

    <!-- Gsap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>

    {{-- Jquery --}}
    <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js') }}"></script>
    <title>aa</title>
</head>

<body class="light">
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="index.html"><img src="./assets/compiled/svg/logo.svg" alt="Logo"></a>
                        </div>
                        <div class="header-top-right">

                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown"
                                    class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2">
                                        <img src="./assets/compiled/jpg/1.jpg" alt="Avatar">
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name">John Ducky</h6>
                                        <p class="user-dropdown-status text-sm text-muted">Member</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    aria-labelledby="topbarUserDropdown">
                                    <li><a class="dropdown-item" href="#">My Account</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="auth-login.html">Logout</a></li>
                                </ul>
                            </div>

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <ul>



                            <li class="menu-item  ">
                                <a href="index.html" class="menu-link">
                                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                                </a>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-stack"></i> Components</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  ">
                                                <a href="component-alert.html" class="submenu-link">Alert</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-badge.html" class="submenu-link">Badge</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-breadcrumb.html" class="submenu-link">Breadcrumb</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-button.html" class="submenu-link">Button</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-card.html" class="submenu-link">Card</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-carousel.html" class="submenu-link">Carousel</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-collapse.html" class="submenu-link">Collapse</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-dropdown.html" class="submenu-link">Dropdown</a>


                                            </li>

                                        </ul>



                                        <ul class="submenu-group">

                                            <li class="submenu-item  ">
                                                <a href="component-list-group.html" class="submenu-link">List Group</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-modal.html" class="submenu-link">Modal</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-navs.html" class="submenu-link">Navs</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-pagination.html"
                                                    class="submenu-link">Pagination</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-progress.html" class="submenu-link">Progress</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-spinner.html" class="submenu-link">Spinner</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="component-tooltip.html" class="submenu-link">Tooltip</a>


                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Extra Components</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="extra-component-avatar.html"
                                                            class="subsubmenu-link">Avatar</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="extra-component-sweetalert.html"
                                                            class="subsubmenu-link">Sweet Alert</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="extra-component-toastify.html"
                                                            class="subsubmenu-link">Toastify</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="extra-component-rating.html"
                                                            class="subsubmenu-link">Rating</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="extra-component-divider.html"
                                                            class="subsubmenu-link">Divider</a>
                                                    </li>

                                                </ul>

                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item active has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-grid-1x2-fill"></i> Layouts</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  ">
                                                <a href="layout-default.html" class="submenu-link">Default Layout</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="layout-vertical-1-column.html" class="submenu-link">1
                                                    Column</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="layout-vertical-navbar.html" class="submenu-link">Vertical
                                                    Navbar</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="layout-rtl.html" class="submenu-link">RTL Layout</a>


                                            </li>



                                            <li class="submenu-item active ">
                                                <a href="layout-horizontal.html" class="submenu-link">Horizontal
                                                    Menu</a>


                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-file-earmark-medical-fill"></i> Forms</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Form Elements</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-input.html"
                                                            class="subsubmenu-link">Input</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-input-group.html"
                                                            class="subsubmenu-link">Input Group</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-select.html"
                                                            class="subsubmenu-link">Select</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-radio.html"
                                                            class="subsubmenu-link">Radio</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-checkbox.html"
                                                            class="subsubmenu-link">Checkbox</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-textarea.html"
                                                            class="subsubmenu-link">Textarea</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="form-layout.html" class="submenu-link">Form Layout</a>


                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Form Validation</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-validation-parsley.html"
                                                            class="subsubmenu-link">Parsley</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Form Editor</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-editor-quill.html"
                                                            class="subsubmenu-link">Quill</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-editor-ckeditor.html"
                                                            class="subsubmenu-link">CKEditor</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-editor-summernote.html"
                                                            class="subsubmenu-link">Summernote</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-editor-tinymce.html"
                                                            class="subsubmenu-link">TinyMCE</a>
                                                    </li>

                                                </ul>

                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-table"></i> Table</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  ">
                                                <a href="table.html" class="submenu-link">Table</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="table-datatable.html" class="submenu-link">Datatable</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="table-datatable-jquery.html" class="submenu-link">Datatable
                                                    (jQuery)</a>


                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-plus-square-fill"></i> Extras</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Widgets</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-widgets-chatbox.html"
                                                            class="subsubmenu-link">Chatbox</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-widgets-pricing.html"
                                                            class="subsubmenu-link">Pricing</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-widgets-todolist.html"
                                                            class="subsubmenu-link">To-do List</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Icons</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-icons-bootstrap-icons.html"
                                                            class="subsubmenu-link">Bootstrap Icons </a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-icons-fontawesome.html"
                                                            class="subsubmenu-link">Fontawesome</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-icons-dripicons.html"
                                                            class="subsubmenu-link">Dripicons</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Charts</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-chart-chartjs.html"
                                                            class="subsubmenu-link">ChartJS</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-chart-apexcharts.html"
                                                            class="subsubmenu-link">Apexcharts</a>
                                                    </li>

                                                </ul>

                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-file-earmark-fill"></i> Pages</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Authentication</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="auth-login.html" class="subsubmenu-link">Login</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="auth-register.html"
                                                            class="subsubmenu-link">Register</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="auth-forgot-password.html"
                                                            class="subsubmenu-link">Forgot Password</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Errors</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="error-403.html" class="subsubmenu-link">403</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="error-404.html" class="subsubmenu-link">404</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="error-500.html" class="subsubmenu-link">500</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="ui-file-uploader.html" class="submenu-link">File Uploader</a>


                                            </li>



                                            <li class="submenu-item  has-sub">
                                                <a href="#" class="submenu-link">Maps</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-map-google-map.html"
                                                            class="subsubmenu-link">Google Map</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="ui-map-jsvectormap.html" class="subsubmenu-link">JS
                                                            Vector Map</a>
                                                    </li>

                                                </ul>

                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="application-email.html" class="submenu-link">Email
                                                    Application</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="application-chat.html" class="submenu-link">Chat
                                                    Application</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="application-gallery.html" class="submenu-link">Photo
                                                    Gallery</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="application-checkout.html" class="submenu-link">Checkout
                                                    Page</a>


                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>



                            <li class="menu-item  has-sub">
                                <a href="#" class="menu-link">
                                    <span><i class="bi bi-life-preserver"></i> Support</span>
                                </a>
                                <div class="submenu ">
                                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                    <div class="submenu-group-wrapper">


                                        <ul class="submenu-group">

                                            <li class="submenu-item  ">
                                                <a href="https://zuramai.github.io/mazer/docs"
                                                    class="submenu-link">Documentation</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="https://github.com/zuramai/mazer/blob/main/CONTRIBUTING.md"
                                                    class="submenu-link">Contribute</a>


                                            </li>



                                            <li class="submenu-item  ">
                                                <a href="https://github.com/zuramai/mazer#donation"
                                                    class="submenu-link">Donate</a>


                                            </li>

                                        </ul>


                                    </div>
                                </div>
                            </li>


                        </ul>
                    </div>
                </nav>

            </header>

            <div class="content-wrapper container">
                <div class="page-heading">
                    <h3>Horizontal Layout</h3>
                </div>

                {{-- Main Content --}}
                <div class="page-content">
                    @yield('container')
                </div>

            </div>

            <!-- Footer -->
            @include('template.layout-horizontal.footer')

        </div>
    </div>


    <script src="{{ asset('assets/static/js/components/dark.js') }} "></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }} "></script>
</body>

</html>
