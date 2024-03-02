@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <div class="card-title">Outsource Companies List</div>
            </div>

            <div class="card-body table-responsive">
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" data-bs-toggle="modal" data-bs-target="#default"
                        onclick="addModal()"><i class="fa fa-plus"></i> </a>
                </div>
                <div id="tableData">
                    <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="No: activate to sort column ascending">No
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending">
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="contact: activate to sort column ascending">
                                    Contact
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="address: activate to sort column ascending">
                                    Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="outsource worker: activate to sort column ascending">
                                    Outsourced Workers
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Action: activate to sort column ascending">
                                    Action
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($data as $outsourceCompany)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $outsourceCompany->name }}</td>
                                    <td>{{ $outsourceCompany->contact }}</td>
                                    <td>{{ $outsourceCompany->address }}</td>
                                    <td>{{ $outsourceCompany->users_count }}</td>
                                    <td>
                                        <a title="mengubah" class="btn btn-outline-primary btn-sm me-1"
                                            data-bs-toggle="modal" data-bs-target="#default"
                                            onclick="editModal('{{ $outsourceCompany->id }}')"><i class="fa fa-edit"></i>
                                        </a>
                                        <a title="hapus" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#default"
                                            onclick="deleteModal('{{ $outsourceCompany->id }}')"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        initDataTable('table')

        function showTable() {
            $.ajax({
                type: "GET",
                url: `api/outsource-company`,
                success: function(response) {
                    let outsourceCompanyData = response.data

                    let data = ''
                    for (let i = 0; i < outsourceCompanyData.length; i++) {
                        let {
                            id,
                            name,
                            contact,
                            address,
                            users_count
                        } = outsourceCompanyData[i]

                        data += `
                        <tr>
                        <td>${i+1}</td>
                        <td>${name}</td>
                        <td>${contact != null ? contact : ''}</td>
                        <td>${address  != null ? contact : ''}</td>
                        <td>${users_count}</td>
                        <td>
                            <a title="Edit" class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                            <a title="Delete" class="btn btn-outline-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#default" onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
                        </td>
                        </tr>
                        `
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
                    `
                    $('#tableData').html(table)
                    initDataTable('table')
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
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
            $('#modalTitle').html("Add Outsource Company ")
            $('#modalBody').html(`
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
            `)

            $('#modalFooter').html(`<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`)

        }

        function editModal(id) {
            $.ajax({
                type: "GET",
                url: `api/outsource-company/${id}`,
                success: function(response) {
                    console.log(response)
                    let {
                        id,
                        main_company_id,
                        name,
                        contact,
                        address,
                        users_count
                    } = response.data

                    $('#modalTitle').html("Edit User")
                    $('#modalBody').html(`
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
                                <input type="text" id="contact" value="${contact != null ? contact : ''}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="address">Address</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="address" value="${address == null ? '' : address}" class="form-control">
                            </div>
                            <input type="hidden" id="mainCompanyId" value="${main_company_id}">
                        </div>
                    </div>
                </form>
            `)
                    $('#modalFooter').html(
                        `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`)
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })

        }

        function deleteModal(id) {
            $('#modalTitle').html("Delete User")
            $('#modalBody').html(`Are you sure to delete this user`)
            $('#modalFooter').html(`<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Delete</a>`)
        }

        function getRoles() {
            let item
            $.ajax({
                type: "GET",
                url: `api/roles`,
                async: false,
                success: function(response) {
                    item = response.data
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
            return item
        }

        // API
        function save() {
            let name = $('#name').val()
            let contact = $('#contact').val()
            let address = $('#address').val()

            // validasi nama
            if (!name) {
                return showErrorAlert("name cannot be empty")
            }

            let data = {
                name: name,
                contact: contact,
                address: address,
            }

            $.ajax({
                type: "POST",
                url: `api/outsource-company`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                success: function(response) {
                    console.log(response)
                    showSuccessAlert("New Outsource Company Added!")
                    $('#default').modal('hide')
                    return showTable()
                },
                error: function(err) {
                    console.log("gagal")
                    console.log(err.responseText)
                }

            })

        }

        function update(id) {
            let mainCompanyId = $('#mainCompanyId').val()
            let name = $('#name').val()
            let contact = $('#contact').val()
            let address = $('#address').val()
            // validasi nama
            if (!name) {
                return showErrorAlert("Name cannot be empty")
            }


            let data = {
                main_company_id: mainCompanyId,
                name: name,
                contact: contact,
                address: address
            }

            $.ajax({
                type: "PUT",
                url: `api/outsource-company/${id}`,
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response)
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Data edited",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#default').modal('hide')
                        showTable()
                    })

                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        }

        function deleteItem(id) {
            $.ajax({
                type: "DELETE",
                url: `api/outsource-company/${id}`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showSuccessAlert("Data deleted")
                    $('#default').modal('hide')
                    showTable()
                },
                error: function(err) {
                    console.log(err.responseText)
                }

            })
        }
    </script>
@endsection
