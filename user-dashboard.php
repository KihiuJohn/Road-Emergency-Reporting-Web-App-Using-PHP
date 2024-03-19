<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
  // Redirect to the login page if not logged in
  header("Location: app-login.php");
  exit;
}

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="theme-color" content="#000000" />
  <title>SwiftAid</title>
  <meta name="description" content="SwiftAid HTML Mobile Template" />
  <meta name="keywords"
    content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
  <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="manifest" href="__manifest.json" />
  <link href="assets/css/c3.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <!-- loader -->
  <div id="loader">
    <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon" />
  </div>
  <!-- * loader -->

  <!-- App Header -->
  <div class="appHeader bg-primary text-light">
    <div class="left">
      <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
        <ion-icon name="menu-outline"></ion-icon>
      </a>
    </div>
    <div class="pageTitle">
      <img src="assets/img/logo.png" alt="logo" class="logo" />
    </div>
    <div class="right">
      <a href="app-notifications.html" class="headerButton">
        <ion-icon class="icon" name="notifications-outline"></ion-icon>
        <span class="badge badge-danger">4</span>
      </a>
      </a>
    </div>
  </div>
  <!-- * App Header -->

  <!-- App Capsule -->
  <div id="appCapsule">
    <!-- Wallet Card -->
    <div class="section wallet-card-section pt-1">
      <div class="wallet-card">
            <!-- Line chart content -->
            <div class="col-lg-12">
              <div class="ibox">
                <div class="ibox-title">
                  <h5>Line Chart Example
                  </h5>
                </div>
                <div class="ibox-content">
                  <div>
                    <div id="lineChart"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- * Line chart content -->
      </div>
    </div>

    <!-- Emergency Incidents -->
    <div class="section mt-4">
      <div class="section-heading">
        <h2 class="title">Recent Emergency Incidents</h2>
      </div>
      <div class="transactions">
        <!-- Incident -->
        <a href="#" class="item">
          <div class="detail">
            <!-- Image for the incident (if applicable) -->
            <div>
              <strong>Accident on Main Street</strong>
              <p>Traffic Collision</p>
            </div>
          </div>
          <div class="right">
            <!-- Cost or impact associated with the incident -->
            <div class="price text-danger">Impact: High</div>
          </div>
        </a>
        <!-- * Incident -->
        <!-- Incident -->
        <a href="#" class="item">
          <div class="detail">
            <!-- Image for the incident (if applicable) -->
            <div>
              <strong>Building Fire</strong>
              <p>Fire Emergency</p>
            </div>
          </div>
          <div class="right">
            <!-- Cost or impact associated with the incident -->
            <div class="price text-danger">Impact: Critical</div>
          </div>
        </a>
        <!-- * Incident -->
        <!-- Incident -->
        <a href="#" class="item">
          <div class="detail">
            <!-- Image for the incident (if applicable) -->
            <div>
              <strong>Medical Emergency</strong>
              <p>Health Crisis</p>
            </div>
          </div>
          <div class="right">
            <!-- Cost or impact associated with the incident -->
            <div class="price">Impact: Moderate</div>
          </div>
        </a>
        <!-- * Incident -->
        <!-- Incident -->
        <a href="#" class="item">
          <div class="detail">
            <!-- Image for the incident (if applicable) -->
            <div>
              <strong>Natural Disaster</strong>
              <p>Earthquake</p>
            </div>
          </div>
          <div class="right">
            <!-- Cost or impact associated with the incident -->
            <div class="price text-danger">Impact: Severe</div>
          </div>
        </a>
        <!-- * Incident -->
      </div>
    </div>
    <!-- * Emergency Incidents -->

    <!-- Emergency News -->
    <div class="section full mt-4 mb-3">
      <div class="section-heading padding">
        <h2 class="title">Latest Emergency News</h2>
        <a href="#" class="link">View All</a>
      </div>

      <!-- Carousel for Emergency News -->
      <div class="carousel-multiple splide">
        <div class="splide__track">
          <ul class="splide__list">
            <!-- Emergency News Item -->
            <li class="splide__slide">
              <a href="#">
                <div class="blog-card">
                  <!-- Image for the news (if applicable) -->
                  <div class="text">
                    <h4 class="title">
                      Major Traffic Incident on Highway 101
                    </h4>
                  </div>
                </div>
              </a>
            </li>
            <!-- * Emergency News Item -->

            <!-- Emergency News Item -->
            <li class="splide__slide">
              <a href="#">
                <div class="blog-card">
                  <!-- Image for the news (if applicable) -->
                  <div class="text">
                    <h4 class="title">Building Evacuation Due to Fire Emergency</h4>
                  </div>
                </div>
              </a>
            </li>
            <!-- * Emergency News Item -->

            <!-- Emergency News Item -->
            <li class="splide__slide">
              <a href="#">
                <div class="blog-card">
                  <!-- Image for the news (if applicable) -->
                  <div class="text">
                    <h4 class="title">Medical Team Dispatched for Emergency Response</h4>
                  </div>
                </div>
              </a>
            </li>
            <!-- * Emergency News Item -->

            <!-- Emergency News Item -->
            <li class="splide__slide">
              <a href="#">
                <div class="blog-card">
                  <!-- Image for the news (if applicable) -->
                  <div class="text">
                    <h4 class="title">Severe Weather Warning Issued for the Region</h4>
                  </div>
                </div>
              </a>
            </li>
            <!-- * Emergency News Item -->
          </ul>
        </div>
      </div>
      <!-- * Carousel for Emergency News -->
    </div>
    <!-- * Emergency News -->


    <!-- app footer -->
    <div class="appFooter">
      <div class="footer-title">
        Copyright © SwiftAid 2021. All Rights Reserved.
      </div>
      Bootstrap 5 based mobile template.
    </div>
    <!-- * app footer -->
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
        <ion-icon name="settings-outline" role="img" class="md hydrated" aria-label="settings outline"></ion-icon>
        <strong>Settings</strong>
      </div>
    </a>
  </div>
  <!-- App Bottom Menu -->
  <!-- App Sidebar -->
  <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body p-0">
          <!-- profile box -->
          <div class="profileBox pt-2 pb-2">
            <div class="image-wrapper">
              <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged w36" />
            </div>
            <div class="in">
              <strong>
                <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>
              </strong>
              <div class="text-muted">4029209</div>
            </div>
            <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
              <ion-icon name="close-outline"></ion-icon>
            </a>
          </div>

          <!-- * profile box -->

          <!-- menu -->
          <div class="listview-title mt-1">Menu</div>
          <ul class="listview flush transparent no-line image-listview">
            <li>
              <a href="index.html" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="pie-chart-outline"></ion-icon>
                </div>
                <div class="in">Overview</div>
              </a>
            </li>
            <li>
              <a href="app-pages.html" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="map"></ion-icon>
                </div>
                <div class="in">Map</div>
              </a>
            </li>
            <li>
              <a href="app-components.html" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="add"></ion-icon>
                </div>
                <div class="in">Report Incident</div>
              </a>
            </li>
            <li>
              <a href="app-cards.html" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="book"></ion-icon>
                </div>
                <div class="in">Logs</div>
              </a>
            </li>
          </ul>
          <!-- * menu -->

          <!-- others -->
          <div class="listview-title mt-1">Others</div>
          <ul class="listview flush transparent no-line image-listview">
            <li>
              <a href="app-settings.php" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="settings-outline"></ion-icon>
                </div>
                <div class="in">Settings</div>
              </a>
            </li>
            <li>
              <a href="#" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="chatbubble-outline"></ion-icon>
                </div>
                <div class="in">Support</div>
              </a>
            </li>
            <li>
              <a href="app-login.html" class="item">
                <div class="icon-box bg-primary">
                  <ion-icon name="log-out-outline"></ion-icon>
                </div>
                <div class="in">Log out</div>
              </a>
            </li>
          </ul>
          <!-- * others -->
        </div>
      </div>
    </div>
  </div>
  <!-- * App Sidebar -->

  <!-- iOS Add to Home Action Sheet -->
  <div class="modal inset fade action-sheet ios-add-to-home" id="ios-add-to-home-screen" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add to Home Screen</h5>
          <a href="#" class="close-button" data-bs-dismiss="modal">
            <ion-icon name="close"></ion-icon>
          </a>
        </div>
        <div class="modal-body">
          <div class="action-sheet-content text-center">
            <div class="mb-1">
              <img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2" />
            </div>
            <div>
              Install <strong>SwiftAid</strong> on your iPhone's home screen.
            </div>
            <div>
              Tap <ion-icon name="share-outline"></ion-icon> and Add to
              homescreen.
            </div>
            <div class="mt-2">
              <button class="btn btn-primary btn-block" data-bs-dismiss="modal">
                CLOSE
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- * iOS Add to Home Action Sheet -->

  <!-- Android Add to Home Action Sheet -->
  <div class="modal inset fade action-sheet android-add-to-home" id="android-add-to-home-screen" tabindex="-1"
    role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add to Home Screen</h5>
          <a href="#" class="close-button" data-bs-dismiss="modal">
            <ion-icon name="close"></ion-icon>
          </a>
        </div>
        <div class="modal-body">
          <div class="action-sheet-content text-center">
            <div class="mb-1">
              <img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2" />
            </div>
            <div>
              Install <strong>SwiftAid</strong> on your Android's home screen.
            </div>
            <div>
              Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to
              homescreen.
            </div>
            <div class="mt-2">
              <button class="btn btn-primary btn-block" data-bs-dismiss="modal">
                CLOSE
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- * Android Add to Home Action Sheet -->
  <script src="assets/js/d3.min.js"></script>
  <script src="assets/js/c3.min.js"></script>

  <script>
    // Ensure the document is ready before attempting to generate the chart
    $(document).ready(function () {
      // Sample data for the line chart
      var lineChartData = {
        columns: [
          ['data1', 30, 200, 100, 400, 150, 250],
        ],
        colors: {
          data1: '#1ab394',
        },
        type: 'line',
      };

      // Initialize C3 chart with the lineChartData
      c3.generate({
        bindto: '#lineChart',
        data: lineChartData,
      });
    });
  </script>
  <!--Map Scripts-->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="assets/js/script.js"></script>
  <!-- ========= JS Files =========  -->
  <!-- Bootstrap -->
  <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <!-- Splide -->
  <script src="assets/js/plugins/splide/splide.min.js"></script>
  <!-- Base Js File -->
  <script src="assets/js/base.js"></script>

  <script>
    // Add to Home with 2 seconds delay.
    AddtoHome("2000", "once");
  </script>
</body>

</html>