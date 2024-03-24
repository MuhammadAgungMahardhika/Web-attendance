// menampilkan data
showTable();

function showTable() {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/outsource-company`,
        success: function (response) {
            let outsourceCompanyData = response.data;

            let data = "";
            for (let i = 0; i < outsourceCompanyData.length; i++) {
                let { id, name, contact, address, users_count } =
                    outsourceCompanyData[i];

                data += `
                <tr>
                <td>${i + 1}</td>
                <td>${name}</td>
                <td>${contact != null ? contact : ""}</td>
                <td>${address != null ? address : ""}</td>
                <td>${users_count}</td>
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
                                            aria-label="contact: activate to sort column ascending">
                                            contact
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="address: activate to sort column ascending">
                                            address
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                            aria-label="Outsourced Workers: activate to sort column ascending">
                                            Outsourced Workers
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

function addModal() {
    const modalHeader = "Add Outsource Company ";
    const modalBody = `
            <form class="form form-horizontal">
            <div class="form-body"> 
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">Name</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="name" class="form-control" placeholder="name" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label for="contact">contact</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="contact" class="form-control" placeholder="contact">
                    </div>
                    <div class="col-md-4">
                        <label for="address">Address</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="address" class="form-control" placeholder="Address">
                    </div>
                </div>
            </div>
        </form>
    `;
    const modalFooter = `<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`;
    showModal(modalHeader, modalBody, modalFooter);
}

function editModal(id) {
    $.ajax({
        type: "GET",
        url: baseUrl + `/api/outsource-company/${id}`,
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
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
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
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
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
        return showErrorAlert("name cannot be empty");
    }

    let data = {
        name: name,
        contact: contact,
        address: address,
    };

    $.ajax({
        type: "POST",
        url: `api/outsource-company`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: JSON.stringify(data),
        success: function (response) {
            showSuccessAlert("New Outsource Company Added!");
            closeModal();
            return showTable();
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
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
        return showErrorAlert("Name cannot be empty");
    }

    let data = {
        main_company_id: mainCompanyId,
        name: name,
        contact: contact,
        address: address,
    };

    $.ajax({
        type: "PUT",
        url: baseUrl + `/api/outsource-company/${id}`,
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
        url: baseUrl + `/api/outsource-company/${id}`,
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            showSuccessAlert("Data deleted");
            closeModal();
            return showTable();
        },
        error: function (err) {
            let errorResponse = JSON.parse(err.responseText);
            const errorMessage = errorResponse.message;
            showToastErrorAlert(errorMessage);
        },
    });
}
