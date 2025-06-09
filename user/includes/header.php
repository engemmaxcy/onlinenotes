<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top px-4 py-2">
    <div class="container-fluid">
        <!-- Brand / Logo -->
        <a href="dashboard.php" class="navbar-brand d-flex align-items-center">
            <h2 class="text-primary mb-0"><i class="fa fa-user me-2"></i></h2>
            <span class="d-lg-none">Dashboard</span>
        </a>

        <!-- Toggler for sidebar and navbar -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav align-items-center">
                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded-circle me-2" src="img/user.jpg" alt="User" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline">
                            <?php
                            $uid = $_SESSION['ocasuid'];
                            $sql = "SELECT * from tbluser where ID = :uid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                                    echo htmlentities($row->FullName);
                                }
                            }
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                        <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->
