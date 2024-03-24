// menampilkan data table
showTable();
openShiftOption();
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

                    data += `
                <tr>
                <td>${i + 1}</td>
                <td>${user.name}</td>
                <td>${shift.name}</td>
                <td>${checkin != null ? checkin : ""}</td>
                <td>${checkout != null ? checkout : ""}</td>
                <td>${date != null ? date : ""}</td>
                <td>${status != null ? status : ""}</td>
                <td>${work_from}</td>
                <td>
                    <a title="Edit" class="btn btn-outline-primary btn-sm me-1"  onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                    <a title="Delete" class="btn btn-outline-danger btn-sm me-1"  onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                </td>
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
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending">
                                            Action
                        </th>
                    
                    </tr>
                </thead>
                <tbody>
                    ${data}
                </tbody>
            </table>
            `;
                $("#tableData").html(table);
                initDataTable("table");
            },
        });
    });

    // Menangani reset tanggal
    $("#dateFilter").on("cancel.daterangepicker", function (ev, picker) {
        $(this).val("");
    });
}

function filterByDateToday() {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/attendance-by-date/${dateNow()}`,
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
                <td>
                    <a title="Edit" class="btn btn-outline-primary btn-sm me-1"  onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                    <a title="Delete" class="btn btn-outline-danger btn-sm me-1"  onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                </td>
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
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending">
                                            Action
                        </th>
                    
                    </tr>
                </thead>
                <tbody>
                    ${data}
                </tbody>
            </table>
            `;
            $("#tableData").html(table);
            initDataTable("table");
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
}

function openShiftOption() {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/shift/`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log(response);
            const responseData = response.data;
            let option = `<option selected="" value="">All...</option>`;
            responseData.forEach((r) => {
                option += `<option value="${r.id}">${r.name}</option>`;
            });
            $("#selectShiftOption").html(option);
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
}
function filterByShift(shiftId) {
    if (!shiftId) {
        console.log("masuk sini");
        return showTable();
    }

    $.ajax({
        type: "GET",
        url: baseUrl + `/api/attendance-by-shift/${shiftId}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
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

                data += `
            <tr>
            <td>${i + 1}</td>
            <td>${user.name}</td>
            <td>${shift.name}</td>
            <td>${checkin != null ? checkin : ""}</td>
            <td>${checkout != null ? checkout : ""}</td>
            <td>${date != null ? date : ""}</td>
            <td>${status != null ? status : ""}</td>
            <td>${work_from}</td>
            <td>
                <a title="Edit" class="btn btn-outline-primary btn-sm me-1"  onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                <a title="Delete" class="btn btn-outline-danger btn-sm me-1"  onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
            </td>
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
                    <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                        aria-label="Action: activate to sort column ascending">
                                        Action
                    </th>
                
                </tr>
            </thead>
            <tbody>
                ${data}
            </tbody>
        </table>
        `;
            $("#tableData").html(table);
            initDataTable("table");
        },
    });
}

function showTable() {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/attendance`,
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
                <td>
                    <a title="Edit" class="btn btn-outline-primary btn-sm me-1"  onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                    <a title="Delete" class="btn btn-outline-danger btn-sm me-1"  onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                </td>
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
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Action: activate to sort column ascending">
                                            Action
                        </th>
                    
                    </tr>
                </thead>
                <tbody>
                    ${data}
                </tbody>
            </table>
            `;
            $("#tableData").html(table);
            initDataTable("table");
        },
        error: function (err) {
            console.log(err.responseText);
        },
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

function editModal(id) {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/attendance/${id}`,
        success: function (response) {
            let { id, main_company_id, name, contact, address, users_count } =
                response.data;

            const modalHeader = "Edit User";
            const modalBody = `
            <form class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="name" value="${name}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="contact">contact</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="contact" value="${
                                    contact != null ? contact : ""
                                }" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="address">Address</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="address" value="${
                                    address == null ? "" : address
                                }" class="form-control">
                            </div>
                            <input type="hidden" id="mainCompanyId" value="${main_company_id}">
                        </div>
                    </div>
                </form>
            `;
            const modalFooter = `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`;
            showModal(modalHeader, modalBody, modalFooter);
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
}

function deleteModal(id) {
    const modalHeader = "Delete User";
    const modalBody = `Are you sure to delete this user`;
    const modalFooter = `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Delete</a>`;
    showModal(modalHeader, modalBody, modalFooter);
}

function getRoles() {
    let item;
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/roles`,
        async: false,
        success: function (response) {
            item = response.data;
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
    return item;
}

// API
function save() {
    let name = $("#name").val();
    let contact = $("#contact").val();
    let address = $("#address").val();

    // validasi nama
    if (!name) {
        return showToastErrorAlert("name cannot be empty");
    }

    let data = {
        name: name,
        contact: contact,
        address: address,
    };

    $.ajax({
        type: "POST",
        url: `api/attendance`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify(data),
        success: function (response) {
            showToastSuccessAlert("New Attendance Company Added!");
            closeModal();
            return showTable();
        },
        error: function (err) {
            console.log("gagal");
            console.log(err.responseText);
        },
    });
}

function update(id) {
    let mainCompanyId = $("#mainCompanyId").val();
    let name = $("#name").val();
    let contact = $("#contact").val();
    let address = $("#address").val();
    // validasi nama
    if (!name) {
        return showToastErrorAlert("Name cannot be empty");
    }

    let data = {
        main_company_id: mainCompanyId,
        name: name,
        contact: contact,
        address: address,
    };

    $.ajax({
        type: "PUT",
        url: baseUrl + `/api/attendance/${id}`,
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
                showTable();
            });
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
}

function deleteItem(id) {
    $.ajax({
        type: "DELETE",
        url: baseUrl + `/api/attendance/${id}`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            showToastSuccessAlert("Data deleted");
            closeModal();
            return showTable();
        },
        error: function (err) {
            console.log(err.responseText);
        },
    });
}
