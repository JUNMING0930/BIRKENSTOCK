<?php include("dataconnection.php");?>

<?php
session_start();

require_once 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['loginbtn']))
{
    $User_Email = $_POST['email'];
    $User_Password = $_POST['password'];
    $Encryption_key = 'Multimedia'; 
    $iv = '1234567891234567';
    function encryption($data,$key,$iv)
    {
        $Encryption_key = base64_encode($key);
        $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
        return base64_encode($Encrypted_data . '::' . $iv);
    }
    function decryption($data, $key)
    {
        $decryption_key = base64_encode($key);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $decryption_key, 0, $iv);
    }
    $User_Encrypted_Email = encryption($User_Email, $Encryption_key, $iv);
    $Login = "SELECT * FROM user WHERE User_Email = '$User_Encrypted_Email' AND User_Status = 1";
    $Login_run = mysqli_query($userconnection,$Login);

    if(mysqli_num_rows($Login_run) > 0)
    {
        $data = mysqli_fetch_array($Login_run);
        $hashed_password = $data['User_Password'];

        if(password_verify($User_Password, $hashed_password))
        {
            $Verify_ID = $data['ID']; 
            $User_Email = decryption($data['User_Email'],$Encryption_key);
            $_SESSION['otp_email'] = $User_Email;
            $_SESSION['Verify_ID'] = $Verify_ID;
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $mail = new PHPMailer(TRUE);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    
            $mail->Username   = "limjunming0930@gmail.com";                     //SMTP username
            $mail->Password   = "vmjkkzzrobmyaznz";                               //SMTP password
            $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom("limjunming0930@gmail.com", "BIRKENSTOCK");
            $mail->addAddress($User_Email);     //Add a recipient
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Login OTP Code';
            $mail->Body    = "Your OTP code is $otp";
    
            $mail->send();
            // Redirect to OTP verification page
            $_SESSION['message'] = "OTP Sent!";
            header("Location: login-otp.php");
            exit();
            
        }
        else
        {
            $_SESSION['message'] = "Invalid Username or Password ";
            ?>
            <script>window.location.href="login.php";</script>
            <?php
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid Username or Password ";
            ?>
            <script>window.location.href="login.php";</script>
            <?php
    }
}
?>