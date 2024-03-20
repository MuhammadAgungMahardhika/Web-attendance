@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title text-center">Profile</h4>
            </div>

            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-12 shadow-sm  bg-light-success p-4">

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="name" placeholder="Name">
                                </div>
                                <div class="col-md-4">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="email" placeholder="Email">
                                </div>
                                <div class="col-md-4">
                                    <label for="phoneNumber">Phone Number</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="number" class="form-control" id="phoneNumber" placeholder="Phone Number">
                                </div>
                                <div class="col-md-4">
                                    <label for="address">Address</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="address" placeholder="address">
                                </div>

                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button class="btn btn-success me-1 mb-1" onclick="showAttendanceHistory()"><i
                                            class="fa fa-history"></i> Show Attendance
                                        History</button>
                                    <button type="submit" class="btn btn-primary me-1 mb-1"><i class="fa fa-key"></i>
                                        Change
                                        password</button>
                                    <button type="submit" class="btn btn-success me-1 mb-1" onclick="update()"><i
                                            class="fa fa-save"></i>
                                        Save</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-lg-6 col-12 shadow-sm bg-light-primary p-4">

                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="main_company">Main company</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="main_company" placeholder="Main Company"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="departmen">Departmen</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="departmen" placeholder="Departmen"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="position">Position</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="position" placeholder="position"
                                        readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="outsource_company">Outsource Company</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" id="outsource_company"
                                        placeholder="Outsource company" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="status">Status</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="status" class="form-control" placeholder="text" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
    <script>
        let baseUrl = '{{ url('') }}'
        let userRoleId = '{{ Auth::user()->role_id }}'

        showProfileData()

        function showProfileData() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: baseUrl + '/' + `api/profile/{{ Auth::user()->id }}`,
                success: function(response) {
                    let userProfile = response.data
                    const status = response.status
                    console.log(userProfile);
                    if (status == 200) {
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
                        } = userProfile

                        // profile info
                        $('#name').val(name)
                        $('#email').val(email)
                        $('#phoneNumber').val(phone_number)
                        $('#address').val(address)
                        $('#status').val(status)


                        // company info
                        if (main_company) {
                            $('#main_company').val(main_company.name)
                        }
                        $('#departmen').val(departmen)
                        $('#position').val(position)
                        if (outsource_company) {
                            $('#outsource_company').val(outsource_company.name)
                        }
                    }
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }




        function showAttendanceHistory() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: baseUrl + '/' + `api/attendance-by-user/{{ Auth::user()->id }}`,
                success: function(response) {
                    let userAttendanceHistory = response.data
                    const status = response.status
                    console.log(userAttendanceHistory);
                    console.log(response)
                    if (status == 200) {
                        for (let i = 0; i < userAttendanceHistory.length; i++) {
                            let {
                                id,
                                user_id,
                                user,
                                checkin,
                                checkout,
                                date,
                                status,
                                work_from,
                            } = userAttendanceHistory[i]

                            let statusBadge = ""
                            if (status == "in") {
                                statusBadge = "badge bg-success"
                            } else if (status == "out") {
                                statusBadge = "badge bg-danger"
                            } else if (status == "late") {
                                statusBadge = "badge bg-warning"
                            }
                            data += `
                                    <tr>
                                    <td>${i+1}</td>
                                    <td>${user.name}</td>
                                    <td>${checkin != null ? checkin : ''}</td>
                                    <td>${checkout  != null ? checkout : ''}</td>
                                    <td>${date  != null ? date : ''}</td>
                                    <td><span class="${statusBadge}">${status  != null ? status : ''} </span></td>
                                    <td>${work_from}</td>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data}
                                        </tbody>
                                    </table>
                                    `
                        // initDataTable('table')

                        const modalHeader =
                            `<h4 class="modal-title" id="myModalLabel20">Users Attendance History</h4>`

                        const modalBody = table
                        const modalFooter = ``
                        return showFullModal(modalHeader, modalBody, modalFooter)
                    }
                },
                error: function(err) {
                    console.log(err)
                }
            })

        }


        function getOutsourcedCompany() {
            let result
            $.ajax({
                type: "GET",
                url: baseUrl + `/api/outsource-company`,
                async: false,
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    result = response.data

                },
                error: function(err) {
                    return console.log(err.responseText)
                }
            });
            return result
        }



        function update() {
            let name = $('#name').val()
            let email = $('#email').val()
            let phoneNumber = $('#phoneNumber').val()
            let status = $('#status').val()
            let address = $('#address').val()
            // validasi nama
            if (!name) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Name cannot be empty",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            // validasi email
            if (!email.match(
                    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                )) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Your email is not valid",
                    showConfirmButton: false,
                    timer: 1500
                })
            }

            // validasi nomor telfon
            if (!phoneNumber) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Phone number cannot be empty",
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            // validasi nomor telfon kurang dari 10 digit
            if (phoneNumber.length < 11) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Your phone number is less than 10 digits",
                    showConfirmButton: false,
                    timer: 1500
                })
            }

            // validasi status
            if (!status) {
                return Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Status cannot be empty",
                    showConfirmButton: false,
                    timer: 1500
                })
            }

            let data = {
                name: name,
                email: email,
                phone_number: phoneNumber,
                status: status,
                address: address
            }

            $.ajax({
                type: "PUT",
                url: baseUrl + `/api/profile/` + '{{ Auth::user()->id }}',
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
                        showProfileData()
                    })

                },
                error: function(err) {
                    console.log(err.responseText)
                }
            })
        }
    </script>
@endsection
