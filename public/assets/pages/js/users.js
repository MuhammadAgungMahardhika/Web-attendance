// menampilkan data
showTable();

function showTable() {
    $.ajax({
        type: "GET",
        url: baseUrl + "/" + "api/users",
        success: function (response) {
            let userData = response.data;

            let data = "";
            for (let i = 0; i < userData.length; i++) {
                let { id, role_id, roles, name, email, status } = userData[i];

                let historyButton = "";
                if (role_id === 3) {
                    historyButton = `<a title="Attendance History" class="btn btn-outline-primary btn-sm me-1" onclick="showAttendanceHistory('${id}')"><i class="fa fa-history"></i></a>`;
                }
                data += `
                <tr>
                <td>${i + 1}</td>
                <td>${roles.role}</td>
                <td>${name}</td>
                <td>${email}</td>
                <td>${status}</td>
                <td>
                    ${historyButton}
                    <a title="Edit" class="btn btn-outline-primary btn-sm me-1" onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                    <a title="Delete" class="btn btn-outline-danger btn-sm me-1" onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
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
                                            aria-label="Role: activate to sort column ascending" >Role
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Name: activate to sort column ascending">Name 
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Email: activate to sort column ascending">
                                            Email
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Status: activate to sort column ascending">
                                            Status
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
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
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

function showAttendanceHistory(id) {
    showModal(
        `<h4 class="modal-title" id="myModalLabel20">Users Attendance History</h4>`,
        "",
        ""
    );
}

function addModal() {
    // get roles data
    let roles = getRoles();
    let roleData = "";
    roles.forEach((r) => {
        roleData += `<option value="${r.id}">${r.role}</option>`;
    });

    // get oursource company data
    let outsourceCompany = getOutsourcedCompany();
    let outsourceCompanyData = "";
    outsourceCompany.forEach((r) => {
        outsourceCompanyData += `<option value="${r.id}">${r.name}</option>`;
    });

    const modalHeader = "Add User";
    const modalBody = `
            <form class="form form-horizontal">
            <div class="form-body"> 
                <div class="row">
                    <div class="col-md-4">
                        <label for="role">Role</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" id="role">
                        ${roleData}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="role">Outsource Company</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" id="outsourceCompany">
                            <option></option>
                        ${outsourceCompanyData}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="name" class="form-control" placeholder="name" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="email" class="form-control" placeholder="email">
                    </div>
                    <div class="col-md-4">
                        <label for="phoneNumber">Phone Number</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number" id="phoneNumber" class="form-control" placeholder="Phone number">
                    </div>
                    <div class="col-md-4">
                        <label for="address">Address</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="col-md-4">
                        <label for="departmen">Departmen</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="departmen" class="form-control" placeholder="Departmen">
                    </div>
                    <div class="col-md-4">
                        <label for="position">Position</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="position" class="form-control" placeholder="Position">
                    </div>
                  
                    <div class="col-md-4">
                        <label for="password">Password</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="password" id="password" class="form-control" placeholder="password" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label for="konfirmasiPassword">Confirmation Password</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="password" id="konfirmasiPassword" class="form-control" placeholder="Confirmation password" autocomplete="off">
                    </div>
                </div>
            </div>
        </form>
    `;
    const modalFooter = `<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`;
    showModal(modalHeader, modalBody, modalFooter);
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

function editModal(id) {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/user/${id}`,
        success: function (response) {
            let {
                role_id,
                main_company_id,
                outsource_company_id,
                name,
                email,
                departmen,
                position,
                phone_number,
                address,
                status,
            } = response.data;

            // Roles data
            let allRole = getRoles();
            let roleData = "";
            allRole.forEach((r) => {
                roleData += `<option ${
                    role_id == r.id ? "selected" : ""
                } value="${r.id}">${r.role}</option>`;
            });

            // Outsource company data
            let allOutsourceCompany = getOutsourcedCompany();
            let outsourceCompanyData = "";

            allOutsourceCompany.forEach((r) => {
                outsourceCompanyData += `<option ${
                    outsource_company_id == r.id ? "selected" : ""
                } value="${r.id}">${r.name}</option>`;
            });

            const modalHeader = "Edit User";
            const modalBody = `
            <form class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="role">Role</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="role">
                                ${roleData}
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="role">Outsource Company</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="outsourceCompany">
                                    <option></option>
                                    ${outsourceCompanyData}
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="name">name</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="name" value="${name}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="email" value="${email}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="departmen">Departmen</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="departmen" value="${
                                    departmen == null ? "" : departmen
                                }" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="position">Position</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="position" value="${
                                    position == null ? "" : position
                                }" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="phoneNumber">Phone Number</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="number" id="phoneNumber" value="${phone_number}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="address">Address</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="address" value="${
                                    address == null ? "" : address
                                }" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-md-8 form-group">
                            <select class="form-select" id="status">
                                <option ${
                                    status == "active" ? "selected" : ""
                                } value="active">active</option>
                                <option ${
                                    status == "inactive" ? "selected" : ""
                                } value="inactive">inactive</option>
                                </select>
                            </div>
                            <input type="hidden" id="mainCompany" value="${main_company_id}" class="form-control">

                        </div>
                    </div>
                </form>
            `;
            const modalFooter = `<a class="btn btn-success btn-sm" onclick="update('${id}')">Edit</a>`;
            showModal(modalHeader, modalBody, modalFooter);
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}

function deleteModal(id) {
    const modalHeader = "Delete User";
    const modalBody = "Are you sure to delete this user";
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
            item = null;
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
    return item;
}

// API
function save() {
    let roleId = $("#role").val();
    let outsourceCompanyId = $("#outsourceCompany").val();
    let name = $("#name").val();
    let email = $("#email").val();
    let departmen = $("#departmen").val();
    let position = $("#position").val();
    let phoneNumber = $("#phoneNumber").val();
    let address = $("#address").val();
    let password = $("#password").val();
    let konfirmasiPassword = $("#konfirmasiPassword").val();

    // validasi nama
    if (!name) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "name cannot be empty",
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
            title: "Email is not valid",
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
            title: "Phone number cannot less than 10 digits",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    // validasi password tidak boleh kosong
    if (!password || !konfirmasiPassword) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Password or password confirmation cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }
    // validasi
    if (konfirmasiPassword != password) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "You password confirmation is not same as your password",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    let data = {
        role_id: roleId,
        outsource_company_id: outsourceCompanyId,
        name: name,
        email: email,
        departmen: departmen,
        position: position,
        phone_number: phoneNumber,
        address: address,
        password: password,
    };

    $.ajax({
        type: "POST",
        url: baseUrl + `/api/user`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify(data),
        success: function (response) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "User added",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                // closeModal()
                showTable();
            });
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}

function update(id) {
    let roleId = $("#role").val();
    let mainCompanyId = $("#mainCompany").val();
    let outsourceCompanyId = $("#outsourceCompany").val();
    let name = $("#name").val();
    let email = $("#email").val();
    let departmen = $("#departmen").val();
    let position = $("#position").val();
    let phoneNumber = $("#phoneNumber").val();
    let status = $("#status").val();
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

    let data = {
        role_id: roleId,
        main_company_id: mainCompanyId,
        outsource_company_id: outsourceCompanyId,
        name: name,
        email: email,
        departmen: departmen,
        position: position,
        phone_number: phoneNumber,
        status: status,
        address: address,
    };

    $.ajax({
        type: "PUT",
        url: baseUrl + `/api/user/${id}`,
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
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}

function deleteItem(id) {
    $.ajax({
        type: "DELETE",
        url: baseUrl + `/api/user/${id}`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data deleted",
                showConfirmButton: false,
                timer: 1500,
            }).then(() => {
                closeModal();
                showTable();
            });
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}