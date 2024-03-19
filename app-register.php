<?php
require 'dbconnect.php';
require 'formvalidation.php';
?>

<!doctype html>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle"></div>
        <div class="right">
            <a href="app-login.php" class="headerButton">
                Login
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->

    <div class="section mt-2 text-center">
        <h1>Register now</h1>
        <h4>Create an account</h4>
    </div>
    <div class="section mb-5 p-2">
        <form action="" method="post">
            <div class="card">
                <div class="card-body">
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Your username"
                                value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                            <?php if (isset($errors['username']))
                                echo "<p class='text-danger'>{$errors['username']}</p>"; ?>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="email1">E-mail</label>
                            <input type="email" class="form-control" id="email1" name="email" placeholder="Your e-mail"
                                value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                            <?php if (isset($errors['email']))
                                echo "<p class='text-danger'>{$errors['email']}</p>"; ?>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="Your phone number"
                                value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                            <?php if (isset($errors['phone']))
                                echo "<p class='text-danger'>{$errors['phone']}</p>"; ?>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="password1">Password</label>
                            <input type="password" class="form-control" id="password1" name="password"
                                autocomplete="off" placeholder="Your password">
                            <?php if (isset($errors['password']))
                                echo "<p class='text-danger'>{$errors['password']}</p>"; ?>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label" for="password2">Password Again</label>
                            <input type="password" class="form-control" id="password2" name="password2"
                                autocomplete="off" placeholder="Type password again">
                            <?php if (isset($errors['password2']))
                                echo "<p class='text-danger'>{$errors['password2']}</p>"; ?>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mt-2 mb-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheckb1" name="agree_terms">
                            <label class="form-check-label" for="customCheckb1">
                                I agree <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and
                                    conditions</a>
                            </label>
                        </div>
                        <?php if (isset($errors['terms']))
                            echo "<p class='text-danger'>{$errors['terms']}</p>"; ?>
                    </div>

                </div>

            </div>
    </div>

    <div class="form-button-group transparent">
        <button type="submit" class="btn btn-primary btn-block btn-lg" name="register">Register</button>
    </div>
    </form>


    </div>

    </div>
    <!-- * App Capsule -->


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

    <!-- Success message -->
    <script>
        // Check if the registration was successful and trigger the SweetAlert popup
        <?php
        if ($registrationSuccessful) {
            echo 'showSuccessAlert();';
            // Reset the registration success flag to avoid showing the SweetAlert on subsequent visits
            $registrationSuccessful = false;
        }
        ?>

        // Function to show the SweetAlert success message
        function showSuccessAlert() {
            swal({
                title: "Registration successful!",
                text: "You can now log in.",
                icon: "success",
                button: "OK",
            }).then(function () {
                // Redirect to 'app-login.php' when the user clicks OK
                window.location.href = 'app-login.php';
            });
        }
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