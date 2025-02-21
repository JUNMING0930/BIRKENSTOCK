<?php
include("dataconnection.php");
$page_title = "OTP Verification";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$Encryption_key = 'Multimedia'; 
$iv = '1234567891234567';
function encryption($data, $key, $iv) {
    $Encryption_key = base64_encode($key);
    $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
    return base64_encode($Encrypted_data . '::' . $iv);
}

if (isset($_POST['verifyotpbtn'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) 
    {
        // OTP is correct, proceed with login
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
        $_SESSION['ID'] = $_SESSION['Verify_ID'];
        unset($_SESSION['Verify_ID']);
        $_SESSION['message'] = "Login Successfully!";
        header("Location: index.php");  
    } 
    else 
    {
        $_SESSION['message'] = "Invalid OTP!";
        header("Location: login-otp.php");
        exit();
    }
}



?>

<?php
include("includes/header.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Welcome to KNM Shoes</title>
    </head>
    <body>
    <div class="colorlib-loader"></div>

        <div id="colorlib-contact">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-wrap">
                            <h3>Verify OTP</h3>
                            <form action="login-otp.php" class="contact-form" method="POST">
                                <div class="row">
                                    <div class="w-100"></div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="otp"><strong>Enter OTP</strong></label>
                                            <input type="text" required style="height:40px" id="otp" name="otp" class="form-control" placeholder="Enter OTP">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button type="submit" name="verifyotpbtn" class="btn btn-primary">Verify OTP</button>
                                        </div>
                                    </div>
                                </div>
                            </form>        
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
    </div>
    
    <?php
    if(isset($_SESSION['message']))
    {
        $message = $_SESSION['message'];
        echo "<script>alert('$message')</script>";
        unset($_SESSION['message']);
    }
    ?>

    </body>
</html>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>