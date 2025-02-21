<?php
session_start();
include("dataconnection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor\autoload.php';

function send_password_reset($User_Email,$Token)
{
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
    $mail->setFrom("limjunming0930@gmail.com", "KNM_SHOES");
    $mail->addAddress($User_Email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';
    $mail->Body    = "<h2>Hello</h2>
                      <h3>You are receiving this email because we received a password reset request for your account.</h3>
                      <br/><br/>
                      <a href='http://localhost/KNM_SHOES/passreset.php?token=$Token'>Click Here</a> to reset your password
                      ";
    $mail->send();                                


}

if(isset($_POST['passresetbtn']))
{
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

    $Email = encryption($_POST['email'],$Encryption_key,$iv);
    $Token = md5(rand());
    $Check_Email = "SELECT * FROM user WHERE User_Email = '$Email'";
    $Check_Email_Run = mysqli_query($userconnection,$Check_Email);

    if(mysqli_num_rows($Check_Email_Run) > 0)
    {
        $User = mysqli_fetch_array($Check_Email_Run);
        $User_Email = $User['User_Email'];
        $User_Decrypted_Email = decryption($User_Email, $Encryption_key);
        
        $Update_Token = "UPDATE user SET User_Token='$Token' WHERE User_Email = '$User_Email'";
        $Update_Token_Run = mysqli_query($userconnection,$Update_Token);
        if($Update_Token_Run)
        {
            send_password_reset($User_Decrypted_Email,$Token);
            $_SESSION['message'] = "We had emailed you a password reset link";
            header("Location: forgotpassword.php");
        }
    }
    else
    {
        $_SESSION['message'] = "No Email Found";
        header("Location: forgotpassword.php");
    }

}
?>