@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card-title">Attendance</div>
                    </div>

                    {{-- Filter menu --}}
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="text-start p-2 shadow-sm border-circle" id="filterMenu">
                            <p>Filter Data</p>
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dateDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    onclick="">
                                    <i class="fa fa-calendar"></i> Filter By Date
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dateDropdown">
                                    <div class="row p-2">
                                        <div class="col-12 form-group">
                                            <input type="text" id="dateFilter" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button id="reloadButton" class="btn btn-outline-secondary btn-sm  me-2 mb-2"
                                onclick="showTable()">
                                <i class="fa fa-sync"></i>
                                Reload Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                {{-- <div class="text-start mb-4" id="addButton">
                    <a title="tambah" class="btn btn-success btn-sm block" onclick="addModal()"><i class="fa fa-plus"></i> </a>
                </div> --}}
                <div id="tableData">

                </div>
            </div>
        </div>
    </section>
    <script>
        let baseUrl = '{{ url('') }}'
        showTable()

        // Filter data by tanggal
        function filterByDate() {
            let dateNow = new Date();
            $('#dateFilter').daterangepicker({
                opens: 'left', // Tampilan kalender saat datepicker dibuka (left/right)
                autoUpdateInput: false, // Otomatis memperbarui input setelah memilih tanggal
                locale: {
                    format: 'YYYY-MM-DD', // Format tanggal yang diinginkan
                    separator: ' to ', // Pemisah untuk rentang tanggal
                }
            });

            // Menangani perubahan tanggal
            $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));

                // Tangkap tanggal awal dan akhir
                var startDate = picker.startDate.format('YYYY-MM-DD');
                var endDate = picker.endDate.format('YYYY-MM-DD');
                // Tampilkan data 
                new Date(startDate)
                new Date(endDate)

                // check jika from date kosong
                if (!startDate) {
                    return Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Please fill the from date",
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                // check jika to date kosong
                if (!endDate) {
                    return Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Please fill the end date",
                        showConfirmButton: false,
                        timer: 1500
                    })
                }

                let data = {
                    id_kandang: idKandang,
                    from: startDate,
                    to: endDate
                }
                $.ajax({
                    type: "POST",
                    url: `/data-kandang/date`,
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify(data),
                    success: function(response) {

                        // asign value
                        let kandangs = response.data
                        let data = ''
                        // adding data kandang data
                        for (let i = 0; i < kandangs.length; i++) {
                            let {
                                date,
                                hari_ke,
                                nama_kandang,
                                alamat_kandang,
                                pakan,
                                minum,
                                bobot,
                                populasi_awal,
                                riwayat_populasi,
                                luas_kandang,
                                classification
                            } = kandangs[i]

                            data += `
                    <tr>
                    <td>${i+1}</td>
                    <td>${date}</td>
                    <td>${hari_ke}</td>
                    <td>${nama_kandang}</td>
                    <td>${alamat_kandang}</td>
                    <td>${luas_kandang}</td>
                    <td>${populasi_awal}</td>
                    <td>${riwayat_populasi}</td>
                    <td>${pakan}</td>
                    <td>${minum}</td>
                    <td>${bobot}</td>
                    <td>${classification}</td>
                    </tr>
                    `
                        }

                        // construct table
                        let table = `
                <table class="table dataTable no-footer" id="table" aria-describedby="table1_info">
                    <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Name: activate to sort column ascending" style="width: 30px;">No
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">Day
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Phone: activate to sort column ascending" style="width: 223.344px;">House
                                    Name
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="City: activate to sort column ascending" style="width: 239.078px;">
                                    House Address
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">House
                                    Area (M<sup>2</sup>)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Initial Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 239.078px;">
                                    Remaining Population (Head)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1" colspan="1"
                                    aria-label="Status: activate to sort column ascending" style="width: 223.344px;">
                                    Feed (G)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Watering (L)
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 223.344px;">
                                    Weight (Kg)
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="table1" rowspan="1"
                                    colspan="1" aria-label="Status: activate to sort column ascending"
                                    style="width: 117.891px;">Classification
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
                    }
                })
            });

            // Menangani reset tanggal
            $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }

        function showTable() {
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/attendance-by-date/${dateNow()}`,
                success: function(response) {
                    let attendanceData = response.data

                    let data = ''
                    for (let i = 0; i < attendanceData.length; i++) {
                        let {
                            id,
                            user_id,
                            user,
                            checkin,
                            checkout,
                            date,
                            status,
                            work_from,
                        } = attendanceData[i]

                        data += `
                        <tr>
                        <td>${i+1}</td>
                        <td>${user.name}</td>
                        <td>${checkin != null ? checkin : ''}</td>
                        <td>${checkout  != null ? checkout : ''}</td>
                        <td>${date  != null ? date : ''}</td>
                        <td>${status  != null ? status : ''}</td>
                        <td>${work_from}</td>
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
            const modalHeader = "Add Outsource Company "
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
            `
            const modalFooter = `<a class="btn btn-success btn-sm" onclick="save()">Submit</a>`
            showModal(modalHeader, modalBody, modalFooter)
        }

        function editModal(id) {
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/attendance/${id}`,
                success: function(response) {
                    let {
                        id,
                        main_company_id,
                        name,
                        contact,
                        address,
                        users_count
                    } = response.data

                    const modalHeader = "Edit User"
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
                    `
                    const modalFooter = `<a class="btn btn-success btn-sm" onclick="update('${id}')">Ubah</a>`
                    showModal(modalHeader, modalBody, modalFooter)
                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })

        }

        function deleteModal(id) {
            const modalHeader = "Delete User"
            const modalBody = `Are you sure to delete this user`
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
                url: `api/attendance`,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify(data),
                success: function(response) {
                    showSuccessAlert("New Outsource Company Added!")
                    closeModal()
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
                url: baseUrl + `/api/attendance/${id}`,
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
                    console.log(err.responseText)
                }
            })
        }

        function deleteItem(id) {
            $.ajax({
                type: "DELETE",
                url: baseUrl + `/api/attendance/${id}`,
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
                    console.log(err.responseText)
                }

            })
        }
    </script>
@endsection
