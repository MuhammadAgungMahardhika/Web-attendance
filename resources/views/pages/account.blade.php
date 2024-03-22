@extends('template.layout-vertical.main')
@section('container')
    @php
        $userRoleId = Auth::user()->role_id;
        $userId = Auth::user()->id;
    @endphp
    <script>
        let userRoleId = '{{ $userRoleId }}'
        let userId = '{{ $userId }}'
    </script>
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title text-center">Profile</h4>
            </div>

            <div class="card-body table-responsive">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-6 col-12 shadow-sm   p-4">
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
                            <div class="col-md-4">
                                <label for="status">Status</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="status" class="form-control" placeholder="text" readonly>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1"
                                    onclick="changePasswordModal('{{ $userId }}')"><i class="fa fa-key"></i>
                                    Change
                                    password</button>
                                <button type="submit" class="btn btn-success me-1 mb-1" onclick="update()"><i
                                        class="fa fa-save"></i>
                                    Save</button>
                            </div>
                        </div>
                    </div>
                    @if ($userRoleId == 3)
                        <div class="col-md-6 col-lg-6 col-12 shadow-sm bg-light-primary p-4">
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
                                <div class="col-md-8 form-group">
                                    <span class="text-danger text-sm">*</span> <span class="text-sm">your company
                                        information only can be change by admin</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if ($userRoleId == 3)
                    <div class="row shadow-sm p-4 ">
                        <div class="card-header">
                            <h4 class="card-title text-center">Attendance History</h4>
                        </div>
                        <div class="col-12">
                            <div class="btn-group me-2 mb-4">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="dateDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    onclick="filterByDate()">
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
                            <div class="table-responsive" id="attendanceHistoryTable">

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/pages/js/account.js') }}"></script>
@endsection
