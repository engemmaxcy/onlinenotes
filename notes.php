<?php
session_start();
error_reporting(0);
include('user/includes/dbconnection.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <title>OnlineNotes Sharing System | Notes</title>
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
            <div class="row">
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
                ?>
                <div class="col-lg-6">
                    <div class="properties properties2 mb-30">
                        <div class="properties__card">
                            <div class="properties__img overlay1">
                                <a href="#"><img src="assets/img/featured.jpg" width="300" height="300" alt="Featured Note"></a>
                            </div>
                            <div class="properties__caption">
                                <p><?php echo htmlentities($row->Subject); ?></p>
                                <h3><?php echo htmlentities($row->NotesTitle); ?> By (<?php echo htmlentities($row->FullName); ?>)</h3>
                                <p><?php echo htmlentities($row->NotesDecription); ?></p>

                                <div class="properties__footer d-flex justify-content-between align-items-center"></div>

                                <table border="1" class="table table-bordered">
                                    <?php for ($i = 1; $i <= 4; $i++) {
                                        $file = "File" . $i;
                                        echo "<tr><th width='200'><strong>File $i</strong></th>";
                                        if (empty($row->$file)) {
                                            echo "<td colspan='3' style='text-align: center;'><strong style='color: red'>File is not available</strong></td>";
                                        } else {
                                            echo "<td colspan='3' style='text-align: center;'><a href='user/folder$i/" . htmlentities($row->$file) . "' target='_blank' class='btn btn-primary'>Download File</a></td>";
                                        }
                                        echo "</tr>";
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }
                } ?>
            </div>

            <div align="left">
                <ul class="pagination">
                    <li><a href="?pageno=1"><strong style="color:blue">First</strong></a></li>
                    <li class="<?php echo ($pageno <= 1) ? 'disabled' : ''; ?>">
                        <a href="<?php echo ($pageno <= 1) ? '#' : '?pageno=' . ($pageno - 1); ?>"><strong style="padding-left: 10px; color: blue;">Prev</strong></a>
                    </li>
                    <li class="<?php echo ($pageno >= $total_pages) ? 'disabled' : ''; ?>">
                        <a href="<?php echo ($pageno >= $total_pages) ? '#' : '?pageno=' . ($pageno + 1); ?>"><strong style="padding-left: 10px; color: blue;">Next</strong></a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px; color: blue;">Last</strong></a></li>
                </ul>
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
</body>
</html>
