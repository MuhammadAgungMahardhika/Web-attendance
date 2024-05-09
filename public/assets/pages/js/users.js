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
    const modalHeader = "Add User";
    const modalBody = `
            <form class="form form-horizontal">
            <div class="form-body"> 
                <div class="row">
                    <div class="col-md-4">
                        <label for="role">Role</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" id="role" onclick="selectRole()">
                       
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mainCompany">Main Company</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" id="mainCompany" onclick="selectMainCompany()">
                           
                        </select>
                    </div>
                    <div class="col-md-4">
                     <label for="outsourceCompany">Outsource Company</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" id="outsourceCompany" onclick="selectOutsourceCompany()">
                            
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

function selectRole(roleId = null) {
    const roleOptionLenght = $("#role option").length;
    if (roleOptionLenght != 0) {
        return;
    }
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/roles`,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            const responseData = response.data;

            let dataOption = `<option value=""></option>`;
            responseData.forEach((r) => {
                dataOption += `<option value="${r.id}"
                ${roleId != null && roleId == r.id ? "selected" : ""}>
                ${r.role}
                </option>`;
            });
            $("#role").html(dataOption);
        },
        error: function (err) {
            result = null;
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}
function selectOutsourceCompany(outsourceCompanyId = null) {
    const outsourceCompanyOptionLenght = $("#outsourceCompany option").length;
    if (outsourceCompanyOptionLenght != 0) {
        return;
    }
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/outsource-company`,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            const responseData = response.data;

            let dataOption = `<option value=""></option>`;
            responseData.forEach((r) => {
                dataOption += `<option value="${r.id}" ${
                    outsourceCompanyId != null && outsourceCompanyId == r.id
                        ? "selected"
                        : ""
                }>${r.name}</option>`;
            });
            $("#outsourceCompany").html(dataOption);
        },
        error: function (err) {
            result = null;
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}
function selectMainCompany(mainCompanyId = null) {
    const mainCompanyOptionLenght = $("#mainCompany option").length;
    if (mainCompanyOptionLenght != 0) {
        return;
    }
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/main-company`,
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            const responseData = response.data;
            let dataOption = `<option value=""></option>`;
            responseData.forEach((r) => {
                dataOption += `<option value="${r.id}" ${
                    mainCompanyId != null && mainCompanyId == r.id
                        ? "selected"
                        : ""
                }>${r.name}</option>`;
            });
            $("#mainCompany").html(dataOption);
        },
        error: function (err) {
            result = null;
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
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
                                  
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="mainCompany">Main Company</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="mainCompany">
                                    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="outsourceCompany">Outsource Company</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="outsourceCompany">
                                   
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
            selectRole(role_id);
            selectMainCompany(main_company_id);
            selectOutsourceCompany(outsource_company_id);
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

// API
function save() {
    let roleId = $("#role").val();
    let mainCompanyId = $("#mainCompany").val();
    let outsourceCompanyId = $("#outsourceCompany").val();
    let name = $("#name").val();
    let email = $("#email").val();
    let departmen = $("#departmen").val();
    let position = $("#position").val();
    let phoneNumber = $("#phoneNumber").val();
    let address = $("#address").val();
    let password = $("#password").val();
    let konfirmasiPassword = $("#konfirmasiPassword").val();

    // validasi role
    if (!roleId) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Role cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }

    // validasi main company
    if (!mainCompanyId) {
        return Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Main company cannot be empty",
            showConfirmButton: false,
            timer: 1500,
        });
    }
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
        main_company_id: mainCompanyId,
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
