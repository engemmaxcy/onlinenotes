<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['ocasuid']==0)) {
  header('location:logout.php');
} 
else {
    if(isset($_GET['delid'])) {
        $rid=intval($_GET['delid']);
        $sql="delete from tblnotes where ID=:rid";
        $query=$dbh->prepare($sql);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();
        $_SESSION['success_msg'] = "Data deleted successfully";
        echo "<script>window.location.href = 'manage-notes.php'</script>";     
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>ONSS || Manage Notes</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <!-- DataTables Responsive CSS -->
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        
        <?php include_once('includes/sidebar.php');?>
        <!-- Content Start -->
        <div class="content">
            <?php include_once('includes/header.php');?>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Manage Notes</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="notesTable" class="table text-start align-middle table-bordered table-hover mb-0" style="width:100%">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col" data-priority="1">#</th>
                                    <th scope="col" data-priority="2">Course Unit</th>
                                    <th scope="col" data-priority="3">Notes Title</th>
                                    <th scope="col" data-priority="4">Creation Date</th>
                                    <th scope="col" data-priority="1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ocasuid = $_SESSION['ocasuid'];
                                $sql = "SELECT * from tblnotes where UserID=:ocasuid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':ocasuid', $ocasuid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) { ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($row->Subject); ?></td>
                                            <td><?php echo htmlentities($row->NotesTitle); ?></td>
                                            <td><?php echo htmlentities($row->CreationDate); ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="edit-notes.php?editid=<?php echo htmlentities($row->ID); ?>">Edit</a>
                                                <a class="btn btn-sm btn-danger" href="manage-notes.php?delid=<?php echo ($row->ID); ?>" onclick="return confirm('Do you really want to Delete ?');">Delete</a>
                                            </td>
                                        </tr>
                                <?php
                                        $cnt++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include_once('includes/footer.php');?>
        </div>
        <!-- Content End -->
        <?php include_once('includes/back-totop.php');?>
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

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <!-- Initialize DataTables Responsive -->
    <script>
      $(document).ready(function() {
          $('#notesTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
          });
      });
    </script>

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
<?php
} // Closing the else for session check
?>
