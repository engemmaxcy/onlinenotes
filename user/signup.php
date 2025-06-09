<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $mobno = $_POST['mobno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $ret = "SELECT Email, MobileNumber FROM tbluser WHERE Email = :email OR MobileNumber = :mobno";
    $query = $dbh->prepare($ret);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
    $query->execute();

    if($query->rowCount() == 0) {
        $sql = "INSERT INTO tbluser (FullName, MobileNumber, Email, Password) VALUES (:fname, :mobno, :email, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $_SESSION['toast'] = "<script>
                toastr.success('You have successfully registered');
                setTimeout(function() { window.location.href = 'signin.php'; }, 2000);
            </script>";
        } else {
            $_SESSION['toast'] = "<script>toastr.error('Something went wrong. Please try again.');</script>";
        }
    } else {
        $_SESSION['toast'] = "<script>toastr.warning('Email or Mobile Number already exists.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + Custom Style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <!-- jQuery (required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e2e6ea);
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, .5);
        }
        .brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card p-4">
                    <div class="text-center mb-4">
                        <div class="brand"><i class="fa fa-hashtag me-2"></i></div>
                        <h4 class="mt-2">Create an Account</h4>
                        <p class="text-muted small">Join us to access your library and share books easily.</p>
                    </div>
                    <form method="post">
                        <div class="form-floating mb-3">
                            <input type="text" name="fname" id="fname" class="form-control" placeholder="John Doe" required>
                            <label for="fname">Full Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="mobno" id="mobno" class="form-control" placeholder="077xxxxxxx" pattern="\d{10}" maxlength="10" required>
                            <label for="mobno">Mobile Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100 py-2 mb-3">Sign Up</button>
                        <div class="text-center">
                            <small>Already registered? <a href="signin.php">Sign In</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../includes/footer.php');?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Display Toastr message if set -->
    <?php 
    if(isset($_SESSION['toast'])) {
        echo $_SESSION['toast'];
        unset($_SESSION['toast']);
    }
    ?>
    
</body>
</html>
