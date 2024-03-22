<nav class="navbar navbar-light">
    <div class="container d-block">
        <ul class="navbar-nav ms-auto mb-lg-0">
            {{-- datetime --}}
            <li class="nav-item dropdown  mb-0  mt-4">
                <span id="dateTime">

                </span>
            </li>
        </ul>
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
</script>
