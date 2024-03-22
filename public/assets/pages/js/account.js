// menampilkan data
showProfileData();
showAttendanceHistory();

function showProfileData() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: baseUrl + "/" + `api/profile/${userId}`,
        success: function (response) {
            let userProfileData = response.data;
            let {
                name,
                email,
                phone_number,
                address,
                status,
                departmen,
                position,
                main_company,
                outsource_company,
            } = userProfileData;

            // profile info
            $("#name").val(name);
            $("#email").val(email);
            $("#phoneNumber").val(phone_number);
            $("#address").val(address);
            $("#status").val(status);

            // company info
            if (main_company) {
                $("#main_company").val(main_company.name);
            }
            $("#departmen").val(departmen);
            $("#position").val(position);
            if (outsource_company) {
                $("#outsource_company").val(outsource_company.name);
            }
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function showAttendanceHistory() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: baseUrl + "/" + `api/attendance-by-user/${userId}`,
        success: function (response) {
            let userAttendanceHistory = response.data;

            console.log(userAttendanceHistory);
            let data = "";
            for (let i = 0; i < userAttendanceHistory.length; i++) {
                let {
                    id,
                    user_id,
                    user,
                    shift,
                    checkin,
                    checkout,
                    date,
                    status,
                    work_from,
                } = userAttendanceHistory[i];

                let statusBadge = "";
                if (status == "in") {
                    statusBadge = "badge bg-success";
                } else if (status == "out") {
                    statusBadge = "badge bg-danger";
                } else if (status == "late") {
                    statusBadge = "badge bg-warning";
                }
                data += `
                            <tr>
                            <td>${i + 1}</td>
                            <td>${user.name}</td>
                            <td>${shift.name}</td>
                            <td>${checkin != null ? checkin : ""}</td>
                            <td>${checkout != null ? checkout : ""}</td>
                            <td>${date != null ? date : ""}</td>
                            <td><span class="${statusBadge}">${
                    status != null ? status : ""
                } </span></td>
                            <td>${work_from}</td>
                            </tr>
                            `;
            }

            let table = `
                            <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                                <thead>
                                    <tr>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="No: activate to sort column ascending">No
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="Name: activate to sort column ascending">Name 
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="Shift: activate to sort column ascending">Shift 
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="checkin: activate to sort column ascending">
                                                            checkin
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="checkout: activate to sort column ascending">
                                                            checkout
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="date: activate to sort column ascending">
                                                            date
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="status: activate to sort column ascending">
                                                            status
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                            aria-label="work_from: activate to sort column ascending">
                                                            work_from
                                        </th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data}
                                </tbody>
                            </table>
                            `;
            $("#attendanceHistoryTable").html(table);
            return initDataTable("table");
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}

// Filter data by tanggal
function filterByDate() {
    let dateNow = new Date();
    $("#dateFilter").daterangepicker({
        opens: "left", // Tampilan kalender saat datepicker dibuka (left/right)
        autoUpdateInput: false, // Otomatis memperbarui input setelah memilih tanggal
        locale: {
            format: "YYYY-MM-DD", // Format tanggal yang diinginkan
            separator: " to ", // Pemisah untuk rentang tanggal
        },
    });

    // Menangani perubahan tanggal
    $("#dateFilter").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("YYYY-MM-DD") +
                " to " +
                picker.endDate.format("YYYY-MM-DD")
        );

        // Tangkap tanggal awal dan akhir
        var startDate = picker.startDate.format("YYYY-MM-DD");
        var endDate = picker.endDate.format("YYYY-MM-DD");
        // Tampilkan data
        new Date(startDate);
        new Date(endDate);

        // check jika from date kosong
        if (!startDate) {
            return showToastErrorAlert("Please fill the from date");
        }
        // check jika to date kosong
        if (!endDate) {
            return showToastErrorAlert("Please fill the end date");
        }

        let data = {
            from: startDate,
            to: endDate,
        };
        $.ajax({
            type: "POST",
            url: baseUrl + `/api/attendance-by-date-range`,
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: JSON.stringify(data),
            success: function (response) {
                console.log(response);
                let attendanceData = response.data;

                let data = "";
                for (let i = 0; i < attendanceData.length; i++) {
                    let {
                        id,
                        user_id,
                        user,
                        shift,
                        checkin,
                        checkout,
                        date,
                        status,
                        work_from,
                    } = attendanceData[i];

                    if (status == "in") {
                        statusBadge = "badge bg-success";
                    } else if (status == "out") {
                        statusBadge = "badge bg-danger";
                    } else if (status == "late") {
                        statusBadge = "badge bg-warning";
                    }
                    data += `
                <tr>
                <td>${i + 1}</td>
                <td>${user.name}</td>
                <td>${shift.name}</td>
                <td>${checkin != null ? checkin : ""}</td>
                <td>${checkout != null ? checkout : ""}</td>
                <td>${date != null ? date : ""}</td>
                <td><span class="${statusBadge}">${
                        status != null ? status : ""
                    } </span></td>
                <td>${work_from}</td>
                </tr>
                `;
                }

                let table = `
            <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                <thead>
                    <tr>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="No: activate to sort column ascending">No
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Name: activate to sort column ascending">Name 
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Shift: activate to sort column ascending">Shift 
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="checkin: activate to sort column ascending">
                                            checkin
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="checkout: activate to sort column ascending">
                                            checkout
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="date: activate to sort column ascending">
                                            date
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="status: activate to sort column ascending">
                                            status
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="work_from: activate to sort column ascending">
                                            work_from
                        </th>
                    </tr>
                </thead>
                <tbody>
                    ${data}
                </tbody>
            </table>
            `;
                $("#attendanceHistoryTable").html(table);
                initDataTable("table");
            },
        });
    });

    // Menangani reset tanggal
    $("#dateFilter").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
    });
}

function initDataTable(id) {
    let jquery_datatable = $(`#${id}`).DataTable({
        responsive: true,
        aLengthMenu: [
            [10, 25, 50, 75, 100, 200, -1],
            [10, 25, 50, 75, 100, 200, "All"],
        ],
        pageLength: 10,
    });
}

function getOutsourcedCompany() {
    let result;
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/outsource-company`,
        async: false,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            result = response.data;
        },
        error: function (err) {
            result = null;
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
    return result;
}

function update() {
    let name = $("#name").val();
    let email = $("#email").val();
    let phoneNumber = $("#phoneNumber").val();
    let status = $("#status").val();
    console.log(status);
    let address = $("#address").val();
    // validasi nama
    if (!name) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Name cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }
    // validasi email
    if (
        !email.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        )
    ) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Your email is not valid",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    // validasi nomor telfon
    if (!phoneNumber) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Phone number cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }
    // validasi nomor telfon kurang dari 10 digit
    if (phoneNumber.length < 11) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Your phone number is less than 10 digits",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    // validasi status
    if (!status) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Status cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    let data = {
        name: name,
        email: email,
        phone_number: phoneNumber,
        status: status,
        address: address,
    };

    $.ajax({
        type: "PUT",
        url: baseUrl + `/api/profile/${userId}`,
        data: JSON.stringify(data),
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data edited",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                closeModal();
                showProfileData();
            });
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}
