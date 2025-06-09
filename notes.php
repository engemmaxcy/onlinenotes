<?php
session_start();
error_reporting(0);
include('user/includes/dbconnection.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <title>OnlineNotes Sharing System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/css/gijgo.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/animated-headline.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<?php include_once('includes/header.php'); ?>
<main>
    <section class="slider-area slider-area2">
        <div class="slider-active">
            <div class="single-slider slider-height2">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-11 col-md-12">
                            <div class="hero__caption hero__caption2">
                                <h1 data-animation="bounceIn" data-delay="0.2s">Our Notes</h1>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active">Notes</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="courses-area section-padding40 fix">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="section-tittle text-center mb-55">
                        <h2>Our Featured & Professional Notes</h2>
                    </div>
                </div>
            </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="notesTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Course</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Uploaded By</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pageno = $_GET['pageno'] ?? 1;
                                $no_of_records_per_page = 10;
                                $offset = ($pageno - 1) * $no_of_records_per_page;

                                $ret = "SELECT ID FROM tblnotes";
                                $query1 = $dbh->prepare($ret);
                                $query1->execute();
                                $total_rows = $query1->rowCount();
                                $total_pages = ceil($total_rows / $no_of_records_per_page);

                                $sql = "SELECT tblnotes.*, tbluser.* FROM tblnotes JOIN tbluser ON tblnotes.UserID = tbluser.ID LIMIT $offset, $no_of_records_per_page";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                        echo "<tr>";
                                        echo "<td>" . htmlentities($row->Subject) . "</td>";
                                        echo "<td>" . htmlentities($row->NotesTitle) . "</td>";
                                        echo "<td>" . htmlentities($row->NotesDecription) . "</td>";
                                        echo "<td>" . htmlentities($row->FullName) . "</td>";
                                        echo "<td>";
                                        for ($i = 1; $i <= 4; $i++) {
                                            $file = "File" . $i;
                                            if (!empty($row->$file)) {
                                                echo "<a href='user/folder$i/" . htmlentities($row->$file) . "' class='btn btn-sm btn-primary m-1' target='_blank'>File $i</a> ";
                                            }
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-danger'>No notes found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                </div>
    </div>
</main>

<?php include_once('includes/footer.php'); ?>

<!-- JS here -->
<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/jquery.slicknav.min.js"></script>
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>
<script src="./assets/js/gijgo.min.js"></script>
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<script src="./assets/js/jquery.barfiller.js"></script>
<script src="./assets/js/jquery.counterup.min.js"></script>
<script src="./assets/js/waypoints.min.js"></script>
<script src="./assets/js/jquery.countdown.min.js"></script>
<script src="./assets/js/hover-direction-snake.min.js"></script>
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script>
  $(document).ready(function() {
  $('#notesTable').DataTable({
     responsive: true
  });
 
});
</script>

</body>
</html>


