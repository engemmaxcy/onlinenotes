<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />

    <style>
        /* Equal height cards and flex vertical layout */
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            color: white;
            transition: transform 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem 2.5rem;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
        }

        .dashboard-icon {
            font-size: 5rem;
            opacity: 0.85;
            flex-shrink: 0;
        }

        .dashboard-text {
            margin-left: 1.8rem;
            flex-grow: 1;
        }

        .dashboard-text p {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dashboard-text h4 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.4rem;
            line-height: 1.1;
        }

        .dashboard-text h5 a {
            color: white;
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .dashboard-text h5 a:hover {
            color: #f0f0f0;
            text-decoration: none;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .dashboard-card {
                padding: 1.5rem 1.8rem;
                flex-direction: row;
            }

            .dashboard-icon {
                font-size: 4rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">

        <?php include_once('includes/sidebar.php'); ?>
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php'); ?>

            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <?php
                        $uid = $_SESSION['ocasuid'];
                        $sql = "SELECT * from tbluser where ID=:uid";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $row) {
                        ?>
                                <h1>Hello, <?php echo $row->FullName; ?> <span>  Welcome to your panel</span></h1>
                        <?php
                                $cnt = $cnt + 1;
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>
            <!-- Recent Sales End -->

            <!-- Dashboard Cards -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-xl-4 d-flex">
                        <div class="dashboard-card bg-primary h-100">
                            <i class="fa fa-file dashboard-icon text-white"></i>
                            <div class="dashboard-text">
                                <p>Total Uploaded Subject Notes</p>
                                <?php
                                $sql1 = "SELECT * from tblnotes where UserID=:uid";
                                $query1 = $dbh->prepare($sql1);
                                $query1->bindParam(':uid', $uid, PDO::PARAM_STR);
                                $query1->execute();
                                $totnotes = $query1->rowCount();
                                ?>
                                <h4><?php echo htmlentities($totnotes); ?></h4>
                                <h5><a href="manage-notes.php">View Detail</a></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-xl-4 d-flex">
                        <div class="dashboard-card bg-success h-100">
                            <i class="fa fa-file dashboard-icon text-white"></i>
                            <div class="dashboard-text">
                                <p>Total Uploaded Notes File</p>
                                <?php
                                $sql2 = "SELECT 
                                COUNT(IF(File1 != '', 0, NULL)) AS file,
                                COUNT(IF(File2 != '', 0, NULL)) AS file2,
                                COUNT(IF(File3 != '', 0, NULL)) AS file3,
                                COUNT(IF(File4 != '', 0, NULL)) AS file4
                                FROM tblnotes WHERE UserID = :uid";
                                $query2 = $dbh->prepare($sql2);
                                $query2->bindParam(':uid', $uid, PDO::PARAM_STR);
                                $query2->execute();
                                $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                $totalfiles = 0;
                                foreach ($results2 as $rows) {
                                    $totalfiles = $rows->file + $rows->file2 + $rows->file3 + $rows->file4;
                                }
                                ?>
                                <h4><?php echo htmlentities($totalfiles); ?></h4>
                                <h5><a href="manage-notes.php">View Detail</a></h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            
        </div>
        <!-- Content End -->
        <?php include_once('includes/back-totop.php'); ?>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
<?php } ?>
