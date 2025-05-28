<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $emailOrMob = $_POST['emailormobnum'];
    $password = md5($_POST['password']);

    $sql = "SELECT ID FROM tbluser WHERE (Email=:emailOrMob OR MobileNumber=:emailOrMob) AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':emailOrMob', $emailOrMob, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        $_SESSION['ocasuid'] = $result->ID;
        $_SESSION['login'] = $emailOrMob;

        echo "<script>window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid email/mobile number or password. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3 shadow">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html">
                                <h3 class="text-primary"><i class="fa fa-user me-2"></i></h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="text" name="emailormobnum" class="form-control" placeholder="Email or Mobile Number" required>
                                <label>Email or Mobile Number</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                                <label>Password</label>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100 py-3">Sign In</button>
                        </form>
                        <div class="mt-4 text-center">
                            <p class="mb-1"><a href="../index.php">← Back to Home</a></p>
                            <p>Don't have an account? <a href="signup.php" class="text-primary">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
