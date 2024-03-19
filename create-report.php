<?php
session_start();
require_once 'dbconnect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to handle file upload
function uploadFile()
{
    $targetDir = "uploads/"; // Specify the directory where you want to store uploaded files
    $targetFile = $targetDir . basename($_FILES["uploaded_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid image
    if (isset($_FILES["uploaded_file"]["tmp_name"]) && !empty($_FILES["uploaded_file"]["tmp_name"])) {
        $check = getimagesize($_FILES["uploaded_file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $uploadOk = 0;
    }

    // Check file size (adjust as needed)
    if ($_FILES["uploaded_file"]["size"] > 25000000) { // 25 MB
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return null;
    } else {
        $uniqueFileName = time() . '_' . uniqid() . '.' . $imageFileType;
        if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $targetDir . $uniqueFileName)) {
            return [
                'file_path' => $targetDir . $uniqueFileName,
                'file_type' => $imageFileType
            ];
        } else {
            return null;
        }
    }
}

// Initialize error array
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $full_name = sanitizeInput($_POST["full_name"]);
    $contact_number = sanitizeInput($_POST["contact_number"]);
    $accident_type = isset($_POST["accident_type"]) ? sanitizeInput($_POST["accident_type"]) : null;
    $number_plate = sanitizeInput($_POST["number_plate"]);
    $location_coordinates = isset($_POST["location_coordinates"]) ? sanitizeInput($_POST["location_coordinates"]) : null;
    $accident_datetime = isset($_POST["accident_datetime"]) ? sanitizeInput($_POST["accident_datetime"]) : null;
    $accident_description = isset($_POST["accident_description"]) ? sanitizeInput($_POST["accident_description"]) : null;
    $agree_terms = isset($_POST["agree_terms"]) ? 1 : 0;

    // Validate Full Name
    if (empty($full_name)) {
        $errors['full_name'] = 'Full Name is required';
    }

    // Validate Contact Number
    if (empty($contact_number)) {
        $errors['contact_number'] = 'Contact Number is required';
    } elseif (!preg_match('/^[0-9]{10}$/', $contact_number)) {
        $errors['contact_number'] = 'Contact Number must be 10 digits';
    }

    // Validate Accident Type
    if (empty($accident_type)) {
        $errors['accident_type'] = 'Accident Type is required';
    }

    // Validate GPS Location
    if (empty($location_coordinates)) {
        $errors['location_coordinates'] = 'GPS Location is required';
    }

    // Validate Date and Time
    if (empty($accident_datetime)) {
        $errors['accident_datetime'] = 'Date and Time is required';
    }

    // Validate Description
    if (empty($accident_description)) {
        $errors['accident_description'] = 'Accident Description is required';
    }

    // Upload file and get the file path and type
    $fileData = uploadFile();

    // Check if file upload failed
    if ($fileData === null) {
        $errors['uploaded_file'] = 'Error uploading file';
    } else {
        $uploaded_file_path = $fileData['file_path'];
        $uploaded_file_type = $fileData['file_type'];
    }

    // Check if "Agree to Terms" is checked
    if (!$agree_terms) {
        $errors['agree_terms'] = 'You must agree to the terms';
    }

    // ... (previous code)

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO road_accident_reports (full_name, contact_number, accident_type, number_plate, location_coordinates, accident_datetime, accident_description, uploaded_file, uploaded_file_type, agree_terms) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $full_name, $contact_number, $accident_type, $number_plate, $location_coordinates, $accident_datetime, $accident_description, $uploaded_file_path, $uploaded_file_type, $agree_terms);

        if ($stmt->execute()) {
            // Set a success message for the toast notification
            $successMessage = "Report sent successfully.";

            // Include JavaScript code to display the toast notification
            echo '<script>
                document.addEventListener("DOMContentLoaded", function () {
                    var toast = document.getElementById("toast-11");
                    toast.style.display = "block";
        
                    // Set the success message
                    toast.querySelector(".text").innerText = "' . $successMessage . '";
        
                    // Hide the toast after 3 seconds
                    setTimeout(function () {
                        toast.style.display = "none";
                    }, 3000);
                });
            </script>';
        } else {
            // Log database insertion error
            error_log("Error: " . $sql . "<br>" . $stmt->error);
        }

        $stmt->close();
    }
}
// Log errors and close the database connection
error_log(print_r($errors, true)); // Log errors to PHP error log
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Finapp</title>
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">


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
        <div class="pageTitle">Report an Incident</div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- ... (existing sections) ... -->

        <!-- Road Accident Report Form -->
        <div class="section mt-2">
            <div class="section-title">Report Road Accident </div>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <!-- Full Names -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="full_name">Full Name</label>
                                <input type="text" name="full_name" class="form-control" id="full_name"
                                    placeholder="Enter Full Name"
                                    value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : ''; ?>">
                                <?php if (isset($errors['full_name'])): ?>
                                    <p class="text-danger">
                                        <?php echo $errors['full_name']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <!-- Contact Number -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="contact_number">Contact Number</label>
                                <input type="tel" name="contact_number" class="form-control" id="contact_number"
                                    placeholder="Enter Contact Number"
                                    value="<?php echo isset($_POST['contact_number']) ? $_POST['contact_number'] : ''; ?>">
                                <?php if (isset($errors['contact_number'])): ?>
                                    <p class="text-danger">
                                        <?php echo $errors['contact_number']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <!-- Type of Road Accident -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="accident_type">Type of Road Accident</label>
                                <select name="accident_type" class="form-control custom-select" id="accident_type">
                                    <option value="" disabled selected>Select Accident Type</option>
                                    <option value="Collision" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Collision') ? 'selected' : ''; ?>>Collision</option>
                                    <option value="Pedestrian Accident" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Pedestrian Accident') ? 'selected' : ''; ?>>Pedestrian
                                        Accident</option>
                                    <option value="Vehicle Rollover" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Vehicle Rollover') ? 'selected' : ''; ?>>Vehicle
                                        Rollover</option>
                                    <option value="Motorcycle Accident" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Motorcycle Accident') ? 'selected' : ''; ?>>Motorcycle
                                        Accident</option>
                                    <option value="Bicycle Accident" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Bicycle Accident') ? 'selected' : ''; ?>>Bicycle
                                        Accident</option>
                                    <option value="Multi-Vehicle Pileup" <?php echo (isset($_POST['accident_type']) && $_POST['accident_type'] == 'Multi-Vehicle Pileup') ? 'selected' : ''; ?>>
                                        Multi-Vehicle Pileup</option>
                                    <!-- Add more options as needed -->
                                </select>
                                <?php if (isset($errors['accident_type'])): ?>
                                    <p class="text-danger">
                                        <?php echo $errors['accident_type']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>


                        <!-- Number Plate (Optional) -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="number_plate">Number Plate (Optional)</label>
                                <input type="text" name="number_plate" class="form-control" id="number_plate"
                                    placeholder="Enter Number Plate"
                                    value="<?php echo isset($_POST['number_plate']) ? $_POST['number_plate'] : ''; ?>">
                                <?php if (isset($errors['number_plate'])): ?>
                                    <p class="text-danger">
                                        <?php echo $errors['number_plate']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <!-- Accident Location -->
                        <div class="form-group basic">
                            <label class="label">Accident Location</label>
                            <div class="input-wrapper">
                                <button type="button" class="btn btn-primary" id="getLocationBtn">Get GPS
                                    Location</button>
                                <div id="locationDisplay"></div>
                                <input type="hidden" name="location_coordinates" id="location_coordinates">
                                <?php if (isset($errors['location_coordinates'])): ?>
                                    <p class="text-danger error-message">
                                        <?php echo $errors['location_coordinates']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Date and Time -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="accident_datetime">Date and Time</label>
                                <input type="datetime-local" name="accident_datetime" class="form-control"
                                    id="accident_datetime">
                                <?php if (isset($errors['accident_datetime'])): ?>
                                    <p class="text-danger error-message">
                                        <?php echo $errors['accident_datetime']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <!-- Accident Description -->
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="accident_description">Accident Description</label>
                                <textarea name="accident_description" id="accident_description" rows="2"
                                    class="form-control"
                                    placeholder="Describe the accident"><?php echo isset($_POST['accident_description']) ? $_POST['accident_description'] : ''; ?></textarea>
                                <?php if (isset($errors['accident_description'])): ?>
                                    <p class="text-danger">
                                        <?php echo $errors['accident_description']; ?>
                                    </p>
                                <?php endif; ?>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>

                        <!-- Upload Photo/Video -->
                        <div class="form-group basic">
                            <div class="custom-file-upload" id="fileUpload1">
                                <input type="file" name="uploaded_file" id="fileuploadInput"
                                    accept=".png, .jpg, .jpeg, .mp4">
                                <?php if (isset($errors['uploaded_file'])): ?>
                                    <p class="text-danger error-message">
                                        <?php echo $errors['uploaded_file']; ?>
                                    </p>
                                <?php endif; ?>
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="arrow-up-circle-outline"></ion-icon>
                                            <i>Upload Photo/Video</i>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Checkbox for agreement -->
                        <div class="custom-control custom-checkbox mt-2 mb-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="customCheckb1" name="agree_terms">
                                <label class="form-check-label" for="customCheckb1">
                                    I agree to <button type="button" class="btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#termsModal">Terms and Conditions</button>
                                </label>
                                <?php if (isset($errors['agree_terms'])): ?>
                                    <p class="text-danger error-message">
                                        <?php echo $errors['agree_terms']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group basic" style="text-align: right;">
                            <button type="submit" class="btn btn-success btn-lg">Submit</button>
                        </div>
                    </form>



                </div>
            </div>
        </div>
        <!-- * Road Accident Report Form -->

        <!-- ... (existing sections) ... -->

    </div>

    <!-- * App Capsule -->



    <!-- toast center iconed -->
    <div id="toast-11" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                Success Message
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light close-button">CLOSE</button>
    </div>
    <!-- toast center iconed -->

    <!-- Terms Modal -->
    <div class="modal fade modalbox" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms and Conditions</h5>
                    <a href="#" data-bs-dismiss="modal">Close</a>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, urna eget finibus
                        fermentum, velit metus maximus erat, nec sodales elit justo vitae sapien. Sed fermentum
                        varius erat, et dictum lorem. Cras pulvinar vestibulum purus sed hendrerit. Praesent et
                        auctor dolor. Ut sed ultrices justo. Fusce tortor erat, scelerisque sit amet diam rhoncus,
                        cursus dictum lorem. Ut vitae arcu egestas, congue nulla at, gravida purus.
                    </p>
                    <p>
                        Donec in justo urna. Fusce pretium quam sed viverra blandit. Vivamus a facilisis lectus.
                        Nunc non aliquet nulla. Aenean arcu metus, dictum tincidunt lacinia quis, efficitur vitae
                        dui. Integer id nisi sit amet leo rutrum placerat in ac tortor. Duis sed fermentum mi, ut
                        vulputate ligula.
                    </p>
                    <p>
                        Vivamus eget sodales elit, cursus scelerisque leo. Suspendisse lorem leo, sollicitudin
                        egestas interdum sit amet, sollicitudin tristique ex. Class aptent taciti sociosqu ad litora
                        torquent per conubia nostra, per inceptos himenaeos. Phasellus id ultricies eros. Praesent
                        vulputate interdum dapibus. Duis varius faucibus metus, eget sagittis purus consectetur in.
                        Praesent fringilla tristique sapien, et maximus tellus dapibus a. Quisque nec magna dapibus
                        sapien iaculis consectetur. Fusce in vehicula arcu. Aliquam erat volutpat. Class aptent
                        taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- * Terms Modal -->

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
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline" role="img" class="md hydrated"
                    aria-label="settings outline"></ion-icon>
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
                            <a href="component-messages.html" class="item">
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

    <script>
        document.getElementById('getLocationBtn').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const locationDisplay = document.getElementById('locationDisplay');

                    // Reverse Geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                        .then(response => response.json())
                        .then(data => {
                            const locationName = data.display_name;
                            locationDisplay.innerHTML = `<p>Location: ${locationName}<br>Coordinates: ${latitude}, ${longitude}</p>`;

                            // Update the hidden input field
                            document.getElementById('location_coordinates').value = `${latitude}, ${longitude}`;
                        })
                        .catch(error => {
                            console.error('Error fetching location details:', error);
                        });
                });
            } else {
                alert('Geolocation is not supported by this browser.');
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