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
                            {{-- Filter by date --}}
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm " type="button"
                                    onclick="filterByDateToday()">
                                    <i class="fa fa-calendar"></i> Today
                                </button>
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
                            {{-- Filter by Shift --}}
                            <div class="btn-group me-2 mb-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    id="shiftDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    onclick="">
                                    <i class="fa fa-clock"></i> Filter By Shift
                                </button>
                                <div class="dropdown-menu" aria-labelledby="shiftDropdown">
                                    <div class="row p-2">
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <select class="form-select" id="selectShiftOption"
                                                    onchange="filterByShift(this.value)">

                                                </select>
                                                <label class="input-group-text" for="selectShiftOption">Shift</label>
                                            </div>
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
                <div id="tableData">

                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/pages/js/attendance.js') }}"></script>
@endsection
