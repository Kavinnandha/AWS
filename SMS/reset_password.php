<?php
session_start();
include 'master/config.php';

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $otp = $connection->real_escape_string($_POST['otp']);
    $plain_password = $connection->real_escape_string($_POST['new_password']);
    $repeat_password = $connection->real_escape_string($_POST['repeat_password']);

    if (time() > $_SESSION['otp_expiry']) {
        $_SESSION['error3'] = "OTP Expired!";
        header("Location: " . $_SERVER['PHP_SELF']);
        session_destroy();
        exit();
    }

    if ($otp !== (string)$_SESSION['otp']) {
        $_SESSION['error1'] = "Invalid OTP!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if ($plain_password !== $repeat_password) {
        $_SESSION['error2'] = "New passwords did not match!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else{
        $new_password = $plain_password;

        $result = $connection->query("SELECT * FROM login WHERE email_id = '$email'");
        if ($result->num_rows > 0) {
            $connection->query("UPDATE login SET password=PASSWORD('$new_password') WHERE email_id = '$email'");
            echo '<script>alert("Password reset successfully!");window.location="index.php";</script>';
            session_destroy();
            exit();
        } else{
            $result = $connection->query("SELECT * from student_information where email='$email'");
            if($result->num_rows >0){
                $connection->query("UPDATE student_information SET password=PASSWORD('$new_password') WHERE email = '$email'");
            echo '<script>alert("Password reset successfully!");window.location="index.php";</script>';
            session_destroy();
            exit();
            }else{
                echo "error updating password";
            }
        }
    }
} else {
    if (isset($_SESSION['email'])) {
        $email_id = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="min-width:350px;">
        <?php if (isset($_SESSION['error1'])): ?>
        <div class="alert alert-danger" id="alertBanner">
            <?php 
            echo $_SESSION['error1'];
            unset($_SESSION['error1']); 
            ?>
        </div>
        <?php endif; ?>
            <?php if (isset($_SESSION['error2'])): ?>
            <div class="alert alert-danger" id="alertBanner">
            <?php 
            echo $_SESSION['error2'];
            unset($_SESSION['error2']); 
            ?>
        </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error3'])): ?>
        <div class="alert alert-danger" id="alertBanner">
            <?php 
            echo $_SESSION['error3'];
            unset($_SESSION['error3']); 
            ?>
        </div>
         <?php endif; ?>
            <div class="card-header text-center">
                Reset Password
            </div>
            <div class="card-body">
                <form action="reset_password.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">OTP :</label>
                        <input type="text" class="form-control" name="otp" placeholder="Enter your OTP" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password :</label>
                        <input type="password" class="form-control" name="new_password" placeholder="Enter your New Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password :</label>
                        <input type="password" class="form-control" name="repeat_password" placeholder="Repeat your New Password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
<?php
    } else {
        echo "No email provided!";
    }
}
?>
