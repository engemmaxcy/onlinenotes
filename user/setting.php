<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['ocasuid']) || strlen($_SESSION['ocasuid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $uid = $_SESSION['ocasuid'];
    $cpassword = md5($_POST['currentpassword']);
    $newpassword = md5($_POST['newpassword']);

    $sql = "SELECT ID FROM tbluser WHERE ID=:uid and Password=:cpassword";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $con = "UPDATE tbluser SET Password=:newpassword WHERE ID=:uid";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':uid', $uid, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();

        $_SESSION['password_changed'] = true;
    } else {
        $_SESSION['password_error'] = true;
    }

    header("Location: change-password.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
    function checkpass() {
        if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
            toastr.error('Passwords do not match!');
            document.changepassword.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include_once('includes/sidebar.php'); ?>

        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php'); ?>

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Change Password</h6>
                            <form method="post" name="changepassword" onsubmit="return checkpass();">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" class="form-control" name="currentpassword" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" name="newpassword" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmpassword" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once('includes/back-totop.php'); ?>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script>

    <!-- Toastr Config & Session-Based Toasts -->
    <script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    <?php if (isset($_SESSION['password_changed'])): ?>
        toastr.success('Your password was successfully changed!');
        setTimeout(function() {
            window.location.href = 'dashboard.php';
        }, 3000);
        <?php unset($_SESSION['password_changed']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['password_error'])): ?>
        toastr.error('Your current password is incorrect!');
        <?php unset($_SESSION['password_error']); ?>
    <?php endif; ?>
</script>
</body>
</html>
