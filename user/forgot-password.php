<?php
session_start();
include('includes/dbconnection.php');

$showToast = '';
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $newPassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

    $sql = "SELECT ID FROM tbluser WHERE Email = :email AND MobileNumber = :mobile";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $updateSql = "UPDATE tbluser SET Password = :newpassword WHERE Email = :email AND MobileNumber = :mobile";
        $updateQuery = $dbh->prepare($updateSql);
        $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
        $updateQuery->bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $updateQuery->bindParam(':newpassword', $newPassword, PDO::PARAM_STR);
        $updateQuery->execute();

        $showToast = 'success';
    } else {
        $showToast = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Form -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3 shadow">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html"><h3 class="text-primary"><i class="fa fa-user me-2"></i></h3></a>
                            <h3>Reset Password</h3>
                        </div>
                        <form method="post" name="chngpwd" onsubmit="return valid();">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                <label>Email Address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" maxlength="10" pattern="[0-9]+" required>
                                <label>Mobile Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
                                <label>New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
                                <label>Confirm Password</label>
                            </div>
                            <div class="mb-4 text-end">
                                <a href="signin.php">Back to Sign In</a>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../includes/footer.php');?>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
    function valid() {
        const newPassword = document.chngpwd.newpassword.value;
        const confirmPassword = document.chngpwd.confirmpassword.value;

        if (newPassword !== confirmPassword) {
            toastr.error("New Password and Confirm Password do not match!");
            return false;
        }
        return true;
    }

    <?php if ($showToast === 'success'): ?>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '3000'
        };
        toastr.success('Your password has been successfully changed.');
        setTimeout(function() {
            window.location.href = 'signin.php';
        }, 2000);
    <?php elseif ($showToast === 'error'): ?>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '3000'
        };
        toastr.error('Invalid email or mobile number.');
    <?php endif; ?>
    </script>
</body>
</html>
