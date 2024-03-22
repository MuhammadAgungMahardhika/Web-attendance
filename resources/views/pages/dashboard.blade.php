@extends('template.layout-vertical.main')
@section('container')
    <style>
        .daftarMenu {
            transition: transform 0.3s ease;
        }

        .daftarMenu:hover {
            transform: scale(1.1);
            opacity: 0.9;
        }
    </style>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center text-center">
                    {{-- Daftar menu untuk super admin --}}
                    @if (Auth::user()->role_id == '1')
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu">
                                <a href="{{ url('main-company') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/main-company.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Main Company</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Daftar menu untuk super admin dan admin --}}
                    @if (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu">
                                <a href="{{ url('outsource-company') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/outsource-company.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Outsource Company</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu">
                                <a href="{{ url('users') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/users.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Users</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu">
                                <a href="{{ url('shift') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/shift.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Shift</h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu ">
                                <a href="{{ url('attendance') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/attendance.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Attendance</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Daftar menu untuk karyawan --}}
                    @if (Auth::user()->role_id == '3')
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="card shadow-sm daftarMenu">
                                <a href="{{ url('account') }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/menu/attendance.jpg') }}"
                                            class="card-img-top img-fluid" alt="singleminded">
                                        <h5 class="card-title mt-4">Account</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection
