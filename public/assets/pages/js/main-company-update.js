let map, directionsRenderer, userMarker, userPosition, infoWindow;
let selectedShape, selectedMarker, drawingManager, geomData;

let mapStyles = [
    {
        featureType: "poi",
        elementType: "labels",
        stylers: [
            {
                visibility: "off",
            },
        ],
    },
];

function initMap() {
    showMap(); //show map ,
    directionsRenderer = new google.maps.DirectionsRenderer(); //render route
    compass(); // mata angin compas on map
}

function searchCenterModal() {
    const modalHeader = "Input latitude and longtitude to search your location";
    const modalBody = `<table class="table table-responsive">
        <tbody>
            <tr>
              <td>Latitude</td>
              <td><input type="text" class="form-control" id="latitude"
                                        name="latitude" value="" autocomplete="off" required
                                        placeholder="ex : -0.9xxxxxxxx">
              </td>
             </tr>
             <tr>
               <td>Longitude</td>
               <td ><input type="text" class="form-control" id="longitude"
                                        name="longitude" value="" autocomplete="off" required
                                        placeholder="ex : 100.9xxxxxxxx">
                </td>
              </tr>
         </tbody>
        </table>`;
    const modalFooter = `<a onclick="searchLatLang()" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        title="search latlng" class="btn icon btn-outline-primary"> 
                  <i class="fa fa-search"></i>
                 </a>`;
    showModal(modalHeader, modalBody, modalFooter);
}

function showMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: -0.948994,
            lng: 100.464795,
        },
        zoom: 18,
        clickableIcons: false,
    });

    // map.setOptions({
    //     styles: mapStyles
    // })
}

// add mata angin
function compass() {
    const legendIcon = `${baseUrl}/assets/images/marker-icon/`;
    const centerControlDiv = document.createElement("div");
    centerControlDiv.style.marginLeft = "10px";
    centerControlDiv.style.marginBottom = "-10px";
    centerControlDiv.innerHTML = `<div class="mb-4"><img src="${legendIcon}mata_angin.png" width="25"></img><div>`;
    map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(
        centerControlDiv
    );
}

//add legend to map
function legend() {
    const legendIcon = `${baseUrl}/assets/images/marker-icon/`;
    $("#legendButton").empty();
    $("#legendButton").append(
        '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hide Legend" class="btn icon btn-primary mx-1" id="legend-map" onclick="hideLegend()"><span class="material-symbols-outlined">visibility_off</span></a>'
    );

    let legend = document.createElement("div");
    legend.id = "legendPanel";
    legend.classList.add("bg-white");
    legend.classList.add("m-2");
    legend.classList.add("p-2");
    legend.classList.add("shadow");
    let content = [];
    content.push('<h6 class="text-center">Legend</h6>');
    content.push(
        `<p><img src="https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png" width="15"></img> You</p>`
    );
    content.push(
        `<p><img src="${baseUrl}/assets/images/marker-icon/main_company_area.png" width="15"></img> Company Area</p>`
    );

    legend.innerHTML = content.join("");
    legend.index = 1;
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(legend);
}
//Hide legend
function hideLegend() {
    $("#legendPanel").remove();
    $("#legendButton").empty();
    $("#legendButton").append(
        '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="show legend" class="btn icon btn-primary mx-1" id="legend"  onclick="legend()"><span class="material-symbols-outlined">visibility</span></a>'
    );
}

//CurrentLocation on Map
function currentLocation() {
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                clearRoute();
                addUserMarkerToMap(pos);
                userPosition = pos;
                map.panTo(userPosition);
            },
            () => {
                handleLocationError(true, currentWindow, map.getCenter());
            }
        );
    } else {
        handleLocationError(false, currentWindow, map.getCenter());
    } // Browser doesn't support Geolocation
}
//Browser doesn't support Geolocation
function handleLocationError(browserHasGeolocation, currentWindow, pos) {
    currentWindow.setPosition(pos);
    currentWindow.setContent(
        browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your browser doesn't support geolocation."
    );
    currentWindow.open(map);
}
// clear route
function clearRoute() {
    if (directionsRenderer) {
        return directionsRenderer.setMap(null);
    }
}
// Add user marker
function addUserMarkerToMap(location) {
    let userPosition = location;
    console.log(location);
    if (userMarker) {
        userMarker.setPosition(userPosition);
    } else {
        userMarker = new google.maps.Marker({
            position: userPosition,
            opacity: 0.8,
            title: "your location",
            animation: google.maps.Animation.DROP,
            draggable: false,
            map: map,
        });

        content = `<div class="text-center">Your Location</div><div class="text-center">Lat : ${location.lat}, Lng: ${location.lng}</div>`;
        userMarker.addListener("click", () => {
            openInfoWindow(userMarker, content);
        });
    }
}
// delete user marker
function clearUser() {
    if (userMarker) {
        userMarker.setMap(null);
        userMarker = null;
    }
}

//open infowindow
function openInfoWindow(marker, content = "Info Window") {
    if (infoWindow != null) {
        infoWindow.close();
    }
    infoWindow = new google.maps.InfoWindow({
        content: content,
    });
    infoWindow.open({
        anchor: marker,
        map,
        shouldFocus: false,
    });
}
//close infowindow
function clearInfoWindow() {
    if (infoWindow) {
        infoWindow.close();
    }
}

//=================================================== Drawing Manager ==================================

if (locationRadius) {
    locationRadius = JSON.parse(locationRadius);
}

$(document).ready(function () {
    initDrawingManager();
    if (locationRadius) {
        addGeom(locationRadius);
        let locationRadiusCoordinates = parsePolygonCoordinates(locationRadius);
        let locationRadiusCenter = calculatePolygonCenter(
            locationRadiusCoordinates
        );
        map.panTo(locationRadiusCenter);
    }
});

// Fungsi untuk memparsing koordinat poligon dari GeoJSON
function parsePolygonCoordinates(geojsonPolygon) {
    let polygonCoordinates = [];
    let coordinates = geojsonPolygon.coordinates[0]; // Ambil koordinat dari properti "coordinates"

    // Iterasi melalui koordinat dan buat objek LatLng untuk setiap titik
    for (let i = 0; i < coordinates.length; i++) {
        let latLng = new google.maps.LatLng(
            coordinates[i][1],
            coordinates[i][0]
        );
        polygonCoordinates.push(latLng);
    }

    return polygonCoordinates;
}

// Fungsi untuk menghitung pusat poligon
function calculatePolygonCenter(polygonCoordinates) {
    let bounds = new google.maps.LatLngBounds();
    for (let i = 0; i < polygonCoordinates.length; i++) {
        bounds.extend(polygonCoordinates[i]);
    }
    return bounds.getCenter();
}

function addGeom(geoJson) {
    // Construct the polygon.

    let color = "#C45A55";
    const a = {
        type: "Feature",
        geometry: geoJson,
    };
    const geom = new google.maps.Data();
    geom.addGeoJson(a);
    geom.setStyle({
        fillColor: color,
        strokeWeight: 2,
        strokeColor: color,
        editable: false,
    });

    geomData = geom;
    geom.setMap(map);
}

function clearGeom() {
    if (geomData) {
        geomData.setMap(null);
        geomData = null;
    }
}
// Remove selected shape on maps
function clearGeomArea() {
    clearGeom();
    document.getElementById("geo-json").value = "";
    if (selectedShape) {
        selectedShape.setMap(null);
        selectedShape = null;
    }
}

// Initialize drawing manager on maps
function initDrawingManager() {
    let color = "#C45A55";
    drawingManager = new google.maps.drawing.DrawingManager();
    const drawingManagerOpts = {
        // drawingMode: google.maps.drawing.OverlayType.MARKER,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [google.maps.drawing.OverlayType.POLYGON],
        },
        markerOptions: {
            icon: baseUrl + "/assets/images/marker-icon/main_company.png",
        },
        polygonOptions: {
            fillColor: color,
            strokeWeight: 2,
            strokeColor: color,
            editable: false,
        },
        map: map,
    };
    drawingManager.setOptions(drawingManagerOpts);

    google.maps.event.addListener(
        drawingManager,
        "overlaycomplete",
        function (event) {
            switch (event.type) {
                case google.maps.drawing.OverlayType.POLYGON:
                    clearGeom();
                    setPolygon(event.overlay);
                    break;
            }
        }
    );
}

function moveCamera(z = 17) {
    map.moveCamera({
        zoom: z,
    });
}

function searchLatLang() {
    let latitude = parseFloat($("#latitude").val());
    let langtitude = parseFloat($("#longitude").val());
    if (!latitude || !longitude) {
        return showErrorAlert("Please input the coordinate!");
    }
    closeModal();
    const pos = {
        lat: latitude,
        lng: langtitude,
    };
    map.panTo(pos);
    moveCamera();
}

function setMarker(shape) {
    let lat = shape.getPosition().lat().toFixed(8);
    let lng = shape.getPosition().lng().toFixed(8);

    if (selectedMarker) {
        selectedMarker.setMap(null);
        selectedMarker = null;
    }
    selectedMarker = shape;
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
}

function setPolygon(shape) {
    if (selectedShape) {
        selectedShape.setMap(null);
        selectedShape = null;
    }
    selectedShape = shape;
    dataLayer = new google.maps.Data();
    dataLayer.add(
        new google.maps.Data.Feature({
            geometry: new google.maps.Data.Polygon([
                selectedShape.getPath().getArray(),
            ]),
        })
    );
    dataLayer.toGeoJson(function (object) {
        document.getElementById("geo-json").value = JSON.stringify(
            object.features[0].geometry
        );
    });
}
