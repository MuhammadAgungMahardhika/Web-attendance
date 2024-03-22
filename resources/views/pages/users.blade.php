@extends('template.layout-vertical.main')
@section('container')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <div class="card-title">User List</div>
            </div>

            <div class="card-body table-responsive">
                <div class="text-start mb-4" id="addButton">
                    <a title="add" class="btn btn-success btn-sm block" onclick="addModal()"><i class="fa fa-plus"></i> </a>
                </div>
                <div id="tableData">

                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/pages/js/users.js') }}"></script>
@endsection
