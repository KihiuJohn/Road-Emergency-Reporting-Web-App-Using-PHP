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
        if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $targetFile)) {
            return $targetFile;
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
    $location_coordinates = sanitizeInput($_POST["location_coordinates"]);
    $accident_datetime = isset($_POST["datetime"]) ? sanitizeInput($_POST["datetime"]) : null;
    $accident_description = isset($_POST["description"]) ? sanitizeInput($_POST["description"]) : null;
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

    // Validate Date and Time
    if (empty($accident_datetime)) {
        $errors['datetime'] = 'Date and Time is required';
    }

    // Validate Description
    if (empty($accident_description)) {
        $errors['description'] = 'Accident Description is required';
    }

    // Upload file and get the file path
    $uploaded_file_path = uploadFile();

    // Check if file upload failed
    if ($uploaded_file_path === null) {
        $errors['uploaded_file'] = 'Error uploading file';
    }

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO road_accident_reports (full_name, contact_number, accident_type, number_plate, location_coordinates, accident_datetime, accident_description, uploaded_file, agree_terms) 
                VALUES ('$full_name', '$contact_number', '$accident_type', '$number_plate', '$location_coordinates', '$accident_datetime', '$accident_description', '$uploaded_file_path', $agree_terms)";

        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
