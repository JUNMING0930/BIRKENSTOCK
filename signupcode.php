<?php include("dataconnection.php");?>
<?php
session_start();
if(isset($_POST['signupbtn']))
{
    $User_Fname = $_POST['fname'];
    $User_Lname = $_POST['lname'];
    $User_Email = $_POST['email'];
    $User_Password = $_POST['password'];
    $User_Cpassword = $_POST['cpassword'];
    $User_Status = '1';
    $User_Token = md5(rand());
    $Encryption_key = 'Multimedia'; 
    $iv = '1234567891234567';
    function encryption($data,$key,$iv)
    {
        $Encryption_key = base64_encode($key);
        $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
        return base64_encode($Encrypted_data . '::' . $iv);;
    }
    $User_Encrypted_Email = encryption($User_Email, $Encryption_key, $iv);
    $Check_User_Email = "SELECT User_Email FROM user WHERE User_Email = '$User_Encrypted_Email'";
    $Check_User_Email_run = mysqli_query($userconnection,$Check_User_Email);
    
    if(!filter_var($User_Email,FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['message'] = "Please Enter Valid Email!";
        header("location: sign-up.php");
    }
    else if(mysqli_num_rows($Check_User_Email_run) > 0 )
    {
    $_SESSION['message'] = "Email Adress is already existed!";
    header("location: sign-up.php");
    }
    else if($User_Password != $User_Cpassword)
    {
        $_SESSION['message'] = "Password is not same as Confirm Password!";
        header("location: sign-up.php");
    }
    else if(!preg_match("/^[a-zA-Z]+$/",$User_Fname))
    {
        $_SESSION['message'] = "Invalid First Name!";
        header("location: sign-up.php");
    }
    else if(!preg_match("/^[a-zA-Z]+$/",$User_Lname))
    {
        $_SESSION['message'] = "Invalid Last Name!";
        header("location: sign-up.php");
    }
    else if(!preg_match("/^[A-Za-z\d^£$%&*()}{@#~?><>,|=_+¬-]{8,}$/",$User_Password))
    {
        $_SESSION['message'] = "Password must be at least 8 characters long!";
        header("location: sign-up.php");
    }
    else if(!preg_match("#[0-9]+#",$User_Password))
    {
        $_SESSION['message'] = "Password must contain at least 1 number!";
        header("location: sign-up.php");
    }
    else if(!preg_match("#[A-Z]+#",$User_Password))
    {
        $_SESSION['message'] = "Password must contain at least 1 Capital Letter!";
        header("location: sign-up.php");
    }
    else if(!preg_match("#[a-z]+#",$User_Password))
    {
        $_SESSION['message'] = "Password must contain at least 1 small Letter!";
        header("location: sign-up.php");
    }
    else if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $User_Password))
    {
        $_SESSION['message'] = "Password must contain at least 1 special character!";
        header("location: sign-up.php");
    }
    else
    {
        $User_Encrypted_Fname = encryption($User_Fname, $Encryption_key,$iv);
        $User_Encrypted_Lname = encryption($User_Lname, $Encryption_key,$iv);

        $User_Hashed_Password = password_hash($User_Password, PASSWORD_DEFAULT);
        $Signup = "INSERT INTO user (User_Email,User_Password,User_First_Name,User_Last_Name,User_Status,User_Token) VALUES ('$User_Encrypted_Email','$User_Hashed_Password','$User_Encrypted_Fname','$User_Encrypted_Lname','$User_Status','$User_Token')";
        $Signup_run = mysqli_query($userconnection,$Signup);
        if($Signup_run)
        {
            $_SESSION['message'] = "Account Created Successfully!";
            header("location: login.php");
        }
    }

    

}
?>