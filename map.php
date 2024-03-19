<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>SwiftAid</title>
    <meta name="description" content="SwiftAid HTML Mobile Template">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">

    <script src='https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.css' rel='stylesheet' />


    <style>
        #map {
            height: calc(100vh - 50px);
            /* Adjusted height to accommodate the bottom menu */
        }

        #locateButton {
            position: fixed;
            bottom: 70px;
            /* Adjusted the bottom position */
            right: 20px;
            z-index: 1000;
            /* Keep the z-index the same */
        }

        .appBottomMenu {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-around;
            background-color: #ffffff;
            border-top: 1px solid #e0e0e0;
            padding: 5px 0;
            z-index: 1000;
            /* Keep the z-index the same */
        }

        .appBottomMenu a {
            color: #616161;
            text-align: center;
            padding: 10px 0;
            text-decoration: none;
            flex: 1;
        }

        .appBottomMenu a:hover {
            color: #2196F3;
        }

        #locateButton,
        #toggleMapType {
            position: fixed;
            bottom: 70px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <!-- loader -->
    <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Map</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div class="section inset mt-5">
        <div id="map"></div>
        <button id="locateButton" class="btn btn-info me-1 mb-1">GPS Location</button>
        <!-- Add this button inside the map-controls div -->
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="user-dashboard.php" class="item active">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Outline</strong>
            </div>
        </a>
        <a href="map.php" class="item">
            <div class="col">
                <ion-icon name="map"></ion-icon>
                <strong>Map</strong>
            </div>
        </a>
        <a href="create-report.php" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="add"></ion-icon>
                </div>
                <strong style="font-weight: bolder">Report</strong>
            </div>
        </a>
        <a href="#" class="item">
            <div class="col">
                <ion-icon name="book"></ion-icon>
                <strong>Logs</strong>
            </div>
        </a>
        <a href="app-settings.php" class="item">
            <div class="col">
                <ion-icon name="settings-outline" role="img" class="md hydrated"
                    aria-label="settings outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div>
    <!-- App Bottom Menu -->

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibWlnZXQxMDAiLCJhIjoiY2xzcm9qczZiMTVjMDJsbzhjMTkwMHZwMyJ9.02ziroTm2DBObmthohnu-g';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/miget100/clsutupi3004301qzgu8667x7', // custom Mapbox style URL
            center: [0, 0], // starting position [lng, lat]
            zoom: 2, // starting zoom
        });

        document.getElementById('locateButton').addEventListener('click', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = [position.coords.longitude, position.coords.latitude];
                        new mapboxgl.Marker().setLngLat(userLocation).addTo(map);
                        map.setCenter(userLocation);
                        map.setZoom(15);
                    },
                    (error) => {
                        console.error("Error getting location:", error.message);
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        });
    </script>

    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="assets/js/plugins/splide/splide.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>
</body>

</html>