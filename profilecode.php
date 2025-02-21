<?php include("dataconnection.php");
session_start();
?>
<?php
if(isset($_POST['saveprobtn']))
{
    $User_ID = $_POST['user_id'];
    $User_Fname = $_POST['fname'];
    $User_Lname = $_POST['lname'];
    $User_Email = $_POST['email'];
    $User_Password = $_POST['pass'];
    $User_Phone = $_POST['phone'];
    $User_Address = $_POST['address'];
    $User_Status = '1';
    $Encryption_key = 'Multimedia'; 
    $iv = '1234567891234567';
    function encryption($data,$key,$iv)
    {
        $Encryption_key = base64_encode($key);
        $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
        return base64_encode($Encrypted_data . '::' . $iv);
    }
    $User_Encrypted_Email = encryption($User_Email, $Encryption_key, $iv);
    $User_Encrypted_Fname = encryption($User_Fname, $Encryption_key, $iv);
    $User_Encrypted_Lname = encryption($User_Lname, $Encryption_key, $iv);
    if($User_Address != NULL)
    {
        $User_Encrypted_Address = encryption($User_Address, $Encryption_key, $iv);
    }
    if($User_Phone != NULL)
    {
        $User_Encrypted_Phone = encryption($User_Phone, $Encryption_key, $iv);
    }

    if(!preg_match("/^[a-zA-Z]+$/",$User_Fname))
    {
        $_SESSION['message'] = "Invalid First Name!";
        header("location: editprofile.php");
    }
    else if(!preg_match("/^[a-zA-Z]+$/",$User_Lname))
    {
        $_SESSION['message'] = "Invalid Last Name!";
        header("location: editprofile.php");
    }
    else if(!preg_match('/^[0-9]{10,11}+$/', $User_Phone))
    {
        $_SESSION['message'] = "Invalid Phone Number!";
        header("location: editprofile.php");
        
    }
    else
    {
        $Editprofile = "UPDATE user SET User_Email='$User_Encrypted_Email',User_Password = '$User_Password',User_First_Name='$User_Encrypted_Fname',User_Last_Name='$User_Encrypted_Lname',User_Status='$User_Status',User_Phone='$User_Encrypted_Phone',User_Address='$User_Encrypted_Address' WHERE ID = $User_ID";
        $Editprofile_run = mysqli_query($userconnection,$Editprofile);
        if($Editprofile)
        {
            $_SESSION['message'] = "Profile Edited Successfully";
            header("Location: editprofile.php");
        }
        else
        {
            $_SESSION['message'] = "Profile Edited Unsuccessfully";
            header("Location: editprofile.php");
        }
    }
    
}

else if(isset($_POST['savepassbtn']))
{
        $User_ID = $_POST['user_id'];
        $Old_Pass = $_POST['opassword'];
        $New_Pass = $_POST['password'];
        $Con_Pass = $_POST['cpassword'];

        $Hash_Old_Pass = "SELECT User_Password FROM user WHERE ID = '$User_ID'";
        $Hash_Old_Pass_Run = mysqli_query($userconnection,$Hash_Old_Pass);
        $data = mysqli_fetch_array($Hash_Old_Pass_Run);
        $Hashed_Old_Pass = $data['User_Password'];

        if(!password_verify($Old_Pass,$Hashed_Old_Pass))
        {
            $_SESSION['message'] = "Old Password is incorrect!";
            header("location: editpass.php");
        }
        else if(password_verify($New_Pass,$Hashed_Old_Pass))
        {
            $_SESSION['message'] = "New Password is same as Old Password!";
            header("location: editpass.php");
        }
        else
        {
            if(!preg_match("/^[A-Za-z\d^£$%&*()}{@#~?><>,|=_+¬-]{8,}$/",$New_Pass))
            {
                $_SESSION['message'] = "Password must be at least 8 characters long!";
                header("location: editpass.php");
            }
            else if(!preg_match("#[0-9]+#",$New_Pass))
            {
                $_SESSION['message'] = "Password must contain at least 1 number!";
                header("location: editpass.php");
            }
            else if(!preg_match("#[A-Z]+#",$New_Pass))
            {
                $_SESSION['message'] = "Password must contain at least 1 Capital Letter!";
                header("location: editpass.php");
            }
            else if(!preg_match("#[a-z]+#",$New_Pass))
            {
                $_SESSION['message'] = "Password must contain at least 1 small Letter!";
                header("location: editpass.php");
            }
            else if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $New_Pass))
            {
                $_SESSION['message'] = "Password must contain at least 1 special character!";
                header("location: editpass.php");
            }
            else if($New_Pass != $Con_Pass)
            {
                $_SESSION['message'] = "Password is not same as Confirm Password!";
                header("location: editpass.php");
            }
            else
            {
                $Hash_New_Pass = password_hash($New_Pass,PASSWORD_DEFAULT);
                $Editpass = "UPDATE user SET User_Password = '$Hash_New_Pass' WHERE ID = $User_ID";
                $Editpass_run = mysqli_query($userconnection,$Editpass);
                if($Editpass_run)
                {
                    $_SESSION['message'] = "Password Changed Successfully";
                    header("Location: editpass.php");
                }
                else
                {
                    $_SESSION['message'] = "Password Changed Unsuccessfully";
                    header("Location: editpass.php");
                }
            }
        }
}
else if(isset($_POST['resetpassbtn']))
{
        $Token = $_POST['user_token'];
        $User_ID = $_POST['user_id'];
        $New_Pass = $_POST['password'];
        $Con_Pass = $_POST['cpassword'];
        if(!empty($Token))
        {
            $Check_Token = "SELECT * FROM user WHERE User_Token = '$Token'";
            $Check_Token_Run = mysqli_query($userconnection,$Check_Token);
                if(mysqli_num_rows($Check_Token_Run) > 0)
                {
                    if(!preg_match("/^[A-Za-z\d^£$%&*()}{@#~?><>,|=_+¬-]{8,}$/",$New_Pass))
                    {
                        $_SESSION['message'] = "Password must be at least 8 characters long!";
                        header("location: passreset.php?token=$Token");
                    }
                    else if(!preg_match("#[0-9]+#",$New_Pass))
                    {
                        $_SESSION['message'] = "Password must contain at least 1 number!";
                        header("location: passreset.php?token=$Token");
                    }
                    else if(!preg_match("#[A-Z]+#",$New_Pass))
                    {
                        $_SESSION['message'] = "Password must contain at least 1 Capital Letter!";
                        header("location: passreset.php?token=$Token");
                    }
                    else if(!preg_match("#[a-z]+#",$New_Pass))
                    {
                        $_SESSION['message'] = "Password must contain at least 1 small Letter!";
                        header("location: passreset.php?token=$Token");
                    }
                    else if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $New_Pass))
                    {
                        $_SESSION['message'] = "Password must contain at least 1 special character!";
                        header("location: passreset.php?token=$Token");
                    }
                    else
                    {
                        if($New_Pass != $Con_Pass)
                        {
                            $_SESSION['message'] = "New Password is not same as Confirm Password!";
                            header("location: passreset.php?token=$Token");
                        }
                        else
                        {
                            $Hash_New_Pass = password_hash($New_Pass,PASSWORD_DEFAULT);
                            $Pass = "UPDATE user SET User_Password='$Hash_New_Pass' WHERE ID = '$User_ID' AND User_Token = '$Token'";
                            $Pass_Query = mysqli_query($userconnection,$Pass);
                            if($Pass_Query)
                            {
                                $New_Token = md5(rand());
                                $Update_Token = "UPDATE user SET User_Token = '$New_Token' WHERE User_Token='$Token'" ;
                                $Update_Token_Run = mysqli_query($userconnection,$Update_Token);
                                $_SESSION['message'] = "Password had been reset successfully!";
                                header("location: login.php");
                            }
                            else
                            {
                                $_SESSION['message'] = "Password had been reset unsuccessfully!";
                                header("location: passreset.php?token=$Token");
                            }
                        }
                    }
            }
            else
            {
            $_SESSION['message'] = "Invalid User Token!";
            header("location: login.php");
            }
        }
        else
        {
            $_SESSION['message'] = "Invalid User Token!";
            header("location: login.php");
        }
            
        
}
include("includes/header.php") 

?>