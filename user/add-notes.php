<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $ocasuid = $_SESSION['ocasuid'];
        $subject = $_POST['subject'];
        $notestitle = $_POST['notestitle'];
        $notesdesc = $_POST['notesdesc'];

        $file1 = $_FILES["file1"]["name"];
        $extension1 = substr($file1, strlen($file1) - 4, strlen($file1));
        $file2 = $_FILES["file2"]["name"];
        $extension2 = substr($file2, strlen($file2) - 4, strlen($file2));
        $file3 = $_FILES["file3"]["name"];
        $extension3 = substr($file3, strlen($file3) - 4, strlen($file3));
        $file4 = $_FILES["file4"]["name"];
        $extension4 = substr($file4, strlen($file4) - 4, strlen($file4));
        $allowed_extensions = array("docs", ".doc", ".pdf");

        if (!in_array($extension1, $allowed_extensions)) {
            echo "<script>toastr.error('File has Invalid format. Only docs / doc/ pdf format allowed');</script>";
        } else {
            $file1 = md5($file1) . time() . $extension1;
            if ($file2 != ''):
                $file2 = md5($file2) . time() . $extension2;
            endif;
            if ($file3 != ''):
                $file3 = md5($file3) . time() . $extension3;
            endif;
            if ($file4 != ''):
                $file4 = md5($file4) . time() . $extension4;
            endif;

            move_uploaded_file($_FILES["file1"]["tmp_name"], "folder1/" . $file1);
            move_uploaded_file($_FILES["file2"]["tmp_name"], "folder2/" . $file2);
            move_uploaded_file($_FILES["file3"]["tmp_name"], "folder3/" . $file3);
            move_uploaded_file($_FILES["file4"]["tmp_name"], "folder4/" . $file4);

            $sql = "INSERT INTO tblnotes(UserID, Subject, NotesTitle, NotesDecription, File1, File2, File3, File4)
                    VALUES(:ocasuid, :subject, :notestitle, :notesdesc, :file1, :file2, :file3, :file4)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':ocasuid', $ocasuid, PDO::PARAM_STR);
            $query->bindParam(':subject', $subject, PDO::PARAM_STR);
            $query->bindParam(':notestitle', $notestitle, PDO::PARAM_STR);
            $query->bindParam(':notesdesc', $notesdesc, PDO::PARAM_STR);
            $query->bindParam(':file1', $file1, PDO::PARAM_STR);
            $query->bindParam(':file2', $file2, PDO::PARAM_STR);
            $query->bindParam(':file3', $file3, PDO::PARAM_STR);
            $query->bindParam(':file4', $file4, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>toastr.success("Notes has been added.");</script>';
            } else {
                echo '<script>toastr.error("Something Went Wrong. Please try again");</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Notes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
<div class="container-fluid position-relative bg-white d-flex p-0">
    <?php include_once('includes/sidebar.php');?>
    <div class="content">
        <?php include_once('includes/header.php');?>
        <div class="container-fluid pt-4 px-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="bg-light rounded p-4">
                        <h6 class="mb-4">Add Notes</h6>
                        <form method="post" id="uploadForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Notes Title</label>
                                <input type="text" class="form-control" name="notestitle" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course Unit</label>
                                <input type="text" class="form-control" name="subject" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course Description</label>
                                <textarea class="form-control" name="notesdesc" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload File</label>
                                <input type="file" class="form-control" name="file1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">More File</label>
                                <input type="file" class="form-control" name="file2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">More File</label>
                                <input type="file" class="form-control" name="file3">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">More File</label>
                                <input type="file" class="form-control" name="file4">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php');?>
    </div>
    <?php include_once('includes/back-totop.php');?>
</div>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "5000"
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
<script>
  toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "timeOut": "2000",           // duration in milliseconds
    "extendedTimeOut": "1000",
    "positionClass": "toast-top-right"
  };
</script>

</body>
</html>
