<?php
session_start();

require_once 'dbconnect.php';

// Initialize registration and login success flags
$registrationSuccessful = false;
$loginSuccessful = false;
$errors = array(); // Array to store error messages

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Registration logic
    if (isset($_POST['register'])) {
        // Fetch form data
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $phone = $_POST["phone"];
        $agreeTerms = isset($_POST["agree_terms"]) ? 1 : 0; // Checkbox value (1 if checked, 0 if not)

        // Validate username format
        if (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $username)) {
            $errors['username'] = "Username must be alphanumeric and have a length between 3 and 20 characters";
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }

        // Check if the email already exists in the database
        $stmt_check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            $errors['email'] = "Email already exists";
        }

        // Validate password format
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            $errors['password'] = "Password must contain at least 8 characters, one capital letter, one special character, and one number";
        }

        // Validate password match
        if ($password != $password2) {
            $errors['password2'] = "Passwords do not match";
        }

        // Validate phone number format
        if (!preg_match("/^\d{10}$/", $phone)) {
            $errors['phone'] = "Phone number must be 10 digits long";
        }

        // Check if the phone number already exists in the database
        $stmt_check_phone = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
        $stmt_check_phone->bind_param("s", $phone);
        $stmt_check_phone->execute();
        $result_check_phone = $stmt_check_phone->get_result();

        if ($result_check_phone->num_rows > 0) {
            $errors['phone'] = "Phone number already exists";
        }

        // Check if user agreed to terms and conditions
        if (!$agreeTerms) {
            $errors['terms'] = "You must agree to the terms and conditions";
        }

        // Hash the password using password_hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database if no errors
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, phone_number, agree_terms, user_type) VALUES (?, ?, ?, ?, ?, 'regular')");
            $stmt->bind_param("ssssi", $username, $email, $hashedPassword, $phone, $agreeTerms);

            if ($stmt->execute()) {
                // Registration Successful
                $registrationSuccessful = true;
                $_SESSION['registration_successful'] = true;
            } else {
                // Debug: Check for database errors
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
        // Check if the registration was successful
        if ($registrationSuccessful) {
            // Set a session variable to indicate successful registration
            $_SESSION['registration_successful'] = true;
        }

    }
    // Login logic
    elseif (isset($_POST['login'])) {
        // Fetch form data
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query to check if the email exists in the database
        $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if email exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $db_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $db_password)) {
                // Password is correct, set session variable for username
                $_SESSION['username'] = $db_username;
                $loginSuccessful = true;

                // Redirect to the user dashboard
                header("Location: user-dashboard.php");
                exit;
            } else {
                $errors['password'] = "Invalid password";
            }
        } else {
            $errors['email'] = "Invalid email";
        }

        $stmt->close();
    }

    $conn->close();
}
?>