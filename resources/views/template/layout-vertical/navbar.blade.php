<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">
                {{-- datetime --}}
                <li class="nav-item dropdown mx-3 mb-0  mt-4">
                    <span id="dateTime">

                    </span>
                </li>
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600">John Ducky</h6>
                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="./assets/compiled/jpg/1.jpg">
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                    style="min-width: 11rem;">
                    <li>
                        <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                    </li>
                    <li><a class="dropdown-item sidebar-item {{ request()->is('account') ? 'active' : '' }}"
                            href="{{ url('account') }}"><i class="icon-mid bi bi-person me-2"></i>
                            My
                            Account</a>
                    </li>
                    <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" onclick="logout()"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                            Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<script>
    new DateAndTime();
    setInterval("DateAndTime()", 1000);

    function DateAndTime() {
        var dt = new Date();
        var Hours = dt.getHours();
        var Min = dt.getMinutes();
        var Sec = dt.getSeconds();
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober",
            "November", "Desember"
        ];


        if (Min < 10) {
            Min === "0" + Min;
        }
        if (Sec < 10) {
            Sec === "0" + Sec;
        }

        var suffix = " AM";
        if (Hours >= 12) {
            suffix = " PM";
            Hours = Hours - 12;
        }
        if (Hours === 0) {
            Hours = 12;
        }
        document.getElementById("dateTime").innerHTML =
            days[dt.getDay()] +
            ", " +
            dt.getDate() +
            " " +
            months[dt.getMonth()] +
            " " +
            dt.getFullYear() + "," + Hours + ":" + Min + ":" + Sec + ":" + suffix;

    }

    function logout() {
        $.ajax({
            type: "POST",
            url: '{{ url('logout') }}',
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(r) {
                let messageStatus = r.status
                if (messageStatus == 200) {
                    showSuccessAlert("You are loged out")
                    window.location = "{{ url('login') }}";
                }
            },
            error: function(e) {
                console.log("keluar sini")
                console.log(e.responseText)
            }
        })
    }
</script>
