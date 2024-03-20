@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <div class="card-title">Shift </div>
            </div>

            <div class="card-body table-responsive">
                <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" onclick="addModal()"><i class="fa fa-plus"></i> </a>
                </div>
                <div id="tableData">

                </div>
            </div>
        </div>
    </section>
    <script>
        let baseUrl = '{{ url('') }}'
        showTable()

        function showTable() {
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/shift`,
                success: function(response) {
                    let shiftData = response.data

                    let data = ''
                    for (let i = 0; i < shiftData.length; i++) {
                        let {
                            id,
                            name,
                            start,
                            end,
                        } = shiftData[i]

                        data += `
                        <tr>
                        <td>${i+1}</td>
                        <td>${name}</td>
                        <td>${start != null ? start : ''}</td>
                        <td>${end  != null ? end : ''}</td>
                        <td>
                            <a title="Edit" class="btn btn-outline-primary btn-sm me-1"  onclick="editModal('${id}')"><i class="fa fa-edit"></i> </a>
                            <a title="Delete" class="btn btn-outline-danger btn-sm me-1"  onclick="deleteModal('${id}')"><i class="fa fa-trash"></i></a>
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
                                                    start
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                                    aria-label="address: activate to sort column ascending">
                                                    end
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
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
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
            const modalHeader = "Add Shift"
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
                                <label for="start">start</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="time" id="start" class="form-control" placeholder="start">
                            </div>
                            <div class="col-md-4">
                                <label for="end">end</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="time" id="end" class="form-control" placeholder="end">
                            </div>
                        </div>
                    </div>
                </form>
            `
            const modalFooter = `<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`
            showModal(modalHeader, modalBody, modalFooter)
        }

        function editModal(id) {
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/shift/${id}`,
                success: function(response) {
                    let {
                        id,
                        name,
                        start,
                        end,
                    } = response.data
                    // convert string json to time format H:I
                    start = convertTimeToHiFormat(start)
                    end = convertTimeToHiFormat(end)

                    console.log(typeof start)
                    const modalHeader = "Edit Shift"
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
                                        <label for="start">start</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="time" id="start" value="${start != null ? start : ''}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end">end</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="time" id="end" value="${end != null ? end : ''}" class="form-control">
                                    </div>
                            
                                </div>
                            </div>
                        </form>
                    `
                    const modalFooter = `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`
                    showModal(modalHeader, modalBody, modalFooter)
                },
                error: function(err) {
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
                }
            })

        }

        function deleteModal(id) {
            const modalHeader = "Delete Shift"
            const modalBody = `Are you sure to delete this shift`
            const modalFooter = `<a class="btn btn-danger btn-sm" onclick="deleteItem('${id}')">Delete</a>`
            showModal(modalHeader, modalBody, modalFooter)
        }

        function getRoles() {
            let item
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/roles`,
                async: false,
                success: function(response) {
                    item = response.data
                },
                error: function(err) {
                    item = null
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
                }
            })
            return item
        }

        // API
        function save() {
            let name = $('#name').val()
            let start = $('#start').val()
            let end = $('#end').val()

            // validasi nama
            if (!name) {
                return showErrorAlert("name cannot be empty")
            }
            // validasi start time
            if (!start) {
                return showErrorAlert("start time cannot be empty")
            }
            // validasi nama
            if (!end) {
                return showErrorAlert("end time cannot be empty")
            }

            let data = {
                name: name,
                start: start,
                end: end,
            }

            $.ajax({
                type: "POST",
                url: `api/shift`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                success: function(response) {
                    showSuccessAlert("New Shift Added!")
                    closeModal()
                    return showTable()
                },
                error: function(err) {
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
                }

            })

        }

        function update(id) {
            let name = $('#name').val()
            let start = $('#start').val()
            let end = $('#end').val()

            // validasi nama
            if (!name) {
                return showErrorAlert("name cannot be empty")
            }
            // validasi start time
            if (!start) {
                return showErrorAlert("start time cannot be empty")
            }
            // validasi nama
            if (!end) {
                return showErrorAlert("end time cannot be empty")
            }



            let data = {
                name: name,
                start: start,
                end: end
            }

            $.ajax({
                type: "PUT",
                url: baseUrl + `/api/shift/${id}`,
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Data edited",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        closeModal()
                        showTable()
                    })

                },
                error: function(err) {
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
                }
            })
        }

        function deleteItem(id) {
            $.ajax({
                type: "DELETE",
                url: baseUrl + `/api/shift/${id}`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    showSuccessAlert("Data deleted")
                    closeModal()
                    return showTable()
                },
                error: function(err) {
                    let errorResponse = JSON.parse(err.responseText)
                    const errorMessage = errorResponse.message
                    showToastErrorAlert(errorMessage)
                }

            })
        }
    </script>
@endsection
