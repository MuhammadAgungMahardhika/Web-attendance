@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <form class="form form-vertical" action="{{ url('api/main-company/map') . '/' . $data['id'] }}" method="POST">
            @method('patch')
            @csrf
            <div class="row">
                <div class="col-12">
                    <!-- Object Location on Map -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('main-company') }}">Main Company</a></li>
                            <li class="breadcrumb-item active sidebar-item" aria-current="page">Map</li>
                        </ol>
                    </nav>
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
                            <input type="hidden" value="{{ $data['id'] }}" name="id">
                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                            <button type="reset" class="btn btn-danger btn-sm">cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </section>
    <script>
        let locationRadius = '{!! $data['location_radius'] != null ? $data['location_radius'] : null !!}'
    </script>
    <script src="{{ asset('assets/pages/js/main-company-update.js') }}"></script>

    <!-- Maps JS -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&callback=initMap&libraries=drawing">
    </script>
@endsection
