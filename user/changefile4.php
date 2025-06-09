<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['ocasuid']) == 0) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $eid = $_GET['editid'];
    $file4 = $_FILES["file4"]["name"];
    $extension4 = substr($file4, strlen($file4) - 4, strlen($file4));
    $allowed_extensions4 = array(".pdf");

    if (!in_array($extension4, $allowed_extensions4)) {
        $_SESSION['error_msg'] = "Invalid file format. Only PDF allowed.";
        header("Location: edit-notes.php?editid=$eid");
        exit();
    } else {
        $newFile4Name = md5($file4) . time() . $extension4;
        move_uploaded_file($_FILES["file4"]["tmp_name"], "folder4/" . $newFile4Name);

        $sql = "UPDATE tblnotes SET File4=:file4 WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':file4', $newFile4Name, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['success_msg'] = "Notes file updated successfully.";
        header("Location: edit-notes.php?editid=$eid");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ONSS || Update Notes File</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Styles -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid position-relative bg-white d-flex p-0">
    
<?php include_once('includes/sidebar.php'); ?>

<div class="content">
<?php include_once('includes/header.php'); ?>

<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Update Note File Four</h6>
                <form method="post" enctype="multipart/form-data">
                <?php
                    $eid = $_GET['editid'];
                    $sql = "SELECT * FROM tblnotes WHERE tblnotes.ID=:eid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) {
                ?>
                    <div class="mb-3">
                        <label class="form-label">Notes Title</label>
                        <input type="text" class="form-control" name="notestitle" value="<?php echo htmlentities($row->NotesTitle); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">View Old File4</label>
                        <a href="folder4/<?php echo $row->File4; ?>">
                            <strong style="color: red">View Old File</strong>
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload New File</label>
                        <input type="file" class="form-control" name="file4" required>
                    </div>
                <?php }} ?>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->

<?php include_once('includes/footer.php'); ?>
</div>

<?php include_once('includes/back-totop.php'); ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="js/main.js"></script>

<script>
toastr.options = {
    closeButton: true,
    progressBar: true,
    timeOut: 3000,
    positionClass: "toast-top-right"
};

<?php if (isset($_SESSION['success_msg'])) { ?>
    toastr.success("<?php echo $_SESSION['success_msg']; ?>");
    <?php unset($_SESSION['success_msg']); } ?>

<?php if (isset($_SESSION['error_msg'])) { ?>
    toastr.error("<?php echo $_SESSION['error_msg']; ?>");
    <?php unset($_SESSION['error_msg']); } ?>
</script>
</body>
</html>
