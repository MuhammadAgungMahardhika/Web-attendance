@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <form class="form form-vertical" action="{{ url('main-company') . '/' . $data['id'] }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">
                    <!-- Object Location on Map -->
                    <div class="card shadow-sm">
                        {{-- Map Head --}}
                        @include('maps.map-head')
                        <!-- Map body -->
                        @include('maps.map-body')
                        <div class="card-footer">
                            <!-- Form data spasial -->
                            <table class="table table-border">
                                <thead>
                                    <th colspan="4">Data spasial </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Location Radius</td>
                                        <td colspan="2"><input type="text" id="geo-json" class="form-control"
                                                name="geojson" placeholder="GeoJSON" readonly="readonly" required
                                                value='<?= $data['location_radius'] ?>'></td>
                                        <td>
                                            <a onclick="clearGeomArea()" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Clear geom area" class="btn icon btn-outline-primary"
                                                id="clear-drawing"> <i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="form-group">
                                <small>*Edit spatial data on map</small>
                                <div class="col-sm-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Object Detail Information -->
                <div class=" col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">Company Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-body">
                                    <!-- Form data nonspasial -->
                                    <div class="form-group">
                                        <label for="name" class="col col-form-label">Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $data['name'] }}" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="contact_person" class=" col col-form-label">Contact person</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="contact"
                                                value="{{ $data['contact'] }}">
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="row my-2">
                                        <div class="col">
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Adress" id="floatingTextarea" style="height: 150px" name="address">{{ $data['address'] }}</textarea>
                                                <label for="floatingTextarea">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $data['id'] }}" name="id">
                                    <button type="submit" class="btn btn-success btn-sm">Save</button>
                                    <button type="reset" class="btn btn-danger btn-sm">cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        @if (Session::has('success'))
            <script>
                showToastSuccessAlert("Success update data!")
            </script>
        @endif
    </section>
    <script>
        let locationRadius = '{!! $data['location_radius'] != null ? $data['location_radius'] : null !!}'
    </script>
    <script src="{{ asset('assets/pages/js/main-company.js') }}"></script>

    <!-- Maps JS -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&callback=initMap&libraries=drawing">
    </script>
@endsection
