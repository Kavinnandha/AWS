<?php
session_start();
include '../master/config.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regsiter_no = $connection->real_escape_string($_POST['register']);
    $result = $connection->query("SELECT * FROM student_information WHERE register_no = '$regsiter_no'");

    if ($result->num_rows > 0) {
        $emailResult = $connection->query("SELECT email FROM student_information WHERE register_no = '$regsiter_no'");
        $emailRow = $emailResult->fetch_assoc();
        $email = $emailRow['email'];
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + (15 * 60); 
        $_SESSION['email'] = $email;

       
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sietproducts@siet.ac.in'; 
            $mail->Password = '$!3T@CSE'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('sietproducts@siet.ac.in', 'SMS Admin');
            $mail->addAddress($email); 

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "You have requested for reset password and the OTP is: <strong>$otp</strong>
                <p>Do not share OTP with anyone.</p>
                <p>If you do not request for Reset Password, please contact us</p> 
                <p>Regards,</p>
                <p>SMS Admin</p>
                <p>Thank you </p>";

            $mail->AltBody = "You have requested for reset password and the OTP is: $otp";

            $mail->send();
            echo 'OTP sent to your email!';
            
            
            header("Location: reset_password.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "Incorrect register number!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class ="d-flex justify-content-center align-items-center vh-100">
        <div class="card d-grid gap-1" style="min-width:350px;">
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" id="alertBanner">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']); 
            ?>
        </div>
    <?php endif; ?>
            <div class="card-header text-center">
                Forgot Password
            </div>
            <div class="card-body">
                <form action="forget_password.php" method="post">
                    <div class="mb-3">
                        <p class="text-center mb-1">Enter your register number below, and we’ll send you</p>
                        <p class="text-center"> an OTP to your email to reset your password.</p>
                        <label class="form-label">Email ID :</label>
                        <div class="mt-2">
                            <input type="text" class="form-control" id="register_no" placeholder="Enter You Register number" name="register" required>
                                                  
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>
</body>
</html>

