<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ocasuid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $uid = $_SESSION['ocasuid'];
        $fname = $_POST['name'];
        $mobno = $_POST['mobilenumber'];
        $email = $_POST['email'];

        try {
            $sql = "UPDATE tbluser SET FullName=:name, MobileNumber=:mobilenumber, Email=:email WHERE ID=:uid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':name', $fname, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':mobilenumber', $mobno, PDO::PARAM_STR);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            
            if ($query->execute()) {
                $_SESSION['success_msg'] = "Profile updated successfully!";
            } else {
                $_SESSION['error_msg'] = "Failed to update profile. Please try again.";
            }
        } catch (Exception $e) {
            $_SESSION['error_msg'] = "Error: " . $e->getMessage();
        }

        header("Location: profile.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid position-relative bg-white d-flex p-0">
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content">
        <?php include_once('includes/header.php'); ?>

        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">User Profile</h6>
                        <form method="post">
                            <?php
                            $uid = $_SESSION['ocasuid'];
                            $sql = "SELECT * FROM tbluser WHERE ID=:uid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                            ?>
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $row->FullName; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $row->Email; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" name="mobilenumber" value="<?php echo $row->MobileNumber; ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Registration Date</label>
                                    <input type="text" class="form-control" value="<?php echo $row->RegDate; ?>" readonly>
                                </div>
                            <?php }} ?>
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>
    </div>

    <?php include_once('includes/back-totop.php'); ?>
</div>

<!-- Scripts -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        timeOut: 3000,
        positionClass: 'toast-top-right'
    };
</script>

<?php
if (isset($_SESSION['success_msg'])) {
    echo "<script>toastr.success('" . $_SESSION['success_msg'] . "');</script>";
    unset($_SESSION['success_msg']);
}
if (isset($_SESSION['error_msg'])) {
    echo "<script>toastr.error('" . $_SESSION['error_msg'] . "');</script>";
    unset($_SESSION['error_msg']);
}
?>
</body>
</html>
