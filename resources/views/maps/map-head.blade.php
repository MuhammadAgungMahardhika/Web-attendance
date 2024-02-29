<div class="card-header">
    <div class="row align-items-center">
        <div class="col-8">
            <h5 class="card-title">Determining Company Area for Users Taking Attendance.</h5>
        </div>
        <div class="col-4">
            <a id="manualLocation" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Current Location"
                class="btn icon btn-primary mx-1 " id="current-position" onclick="currentLocation()">
                <span class="material-symbols-outlined">my_location</span>
            </a>
            <span id="legendButton">
                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Show Legend"
                    class="btn icon btn-primary mx-1 " id="legend-map" onclick="legend();">
                    <span class="material-symbols-outlined">visibility</span>
                </a>
            </span>
            <span id="legendButton">
                <a data-bs-placement="bottom" data-bs-toggle="modal" data-bs-target="#default"
                    title="Search your center" class="btn icon btn-primary mx-1 " id="legend-map"
                    onclick="searchCenterModal()">
                    <span class="material-symbols-outlined">search</span>
                </a>
            </span>
        </div>
    </div>
</div>
