<?php
session_start();
include("dataconnection.php");
require_once 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if(isset($_POST['addItemBtn']))
{
    $Pro_ID = $_POST['pid'];
    $User_ID = $_POST['uid'];
    if(isset($_POST['psize']))
    {
        $Product = "SELECT * FROM product WHERE ID='$Pro_ID'";
        $Product_Run = mysqli_query($dataconnection,$Product);
        if(mysqli_num_rows($Product_Run) > 0)
        {
            $row = mysqli_fetch_array($Product_Run); 
            $Name = $row['Pro_Name'];
            $Price = $row['Pro_Price'];
            $Image = $row['Pro_Image'];
            $Quantity = $_POST['quantity'];
            $Size = $_POST['psize'];
            $Total = $Price * $Quantity;
            $Check_Cart = "SELECT * FROM cart WHERE product_id='$Pro_ID' AND size='$Size' AND user_id='$User_ID'";
            $Check_Cart_Run = mysqli_query($userconnection,$Check_Cart);
            if(mysqli_num_rows($Check_Cart_Run) > 0)
            {
                $Cart = mysqli_fetch_array($Check_Cart_Run);
                $New_qtty = $Cart['qty'] + $Quantity;
                $Check_qtty = "SELECT * FROM stock WHERE Product_ID = '$Pro_ID' AND Product_Size='$Size'";
                $Check_qtty_run = mysqli_query($dataconnection,$Check_qtty);
                $Stock_qtty = mysqli_fetch_array($Check_qtty_run);
                if($New_qtty > $Stock_qtty['Product_Quantity'])
                {
                    $_SESSION['Msg'] = "The product had exceeded current stock!";
                    header("location: products.php?title=$Pro_ID");
                }
                else
                {
                    $query = "UPDATE cart SET qty = $New_qtty WHERE product_id='$Pro_ID' AND size='$Size'";
                    $query_run = mysqli_query($userconnection,$query);
                    if($query_run)
                    {
                        $_SESSION['Msg'] = "The product had been added to the cart!";
                        header("location: products.php?title=$Pro_ID");    
                    }
                    else
                    {
                        header("location: products.php?title=$Pro_ID");    
                    }
                }
            }
            else
            {
                $query = "INSERT INTO cart (user_id,product_id,qty,size,total_price) VALUES ('$User_ID','$Pro_ID','$Quantity','$Size','$Total')";
                $query_run = mysqli_query($userconnection,$query);
        
                if($query_run)
                {
                    $_SESSION['Msg'] = "The product had been added to the cart!";
                    header("location: products.php?title=$Pro_ID");    
                }
                else
                {
                    header("location: products.php?title=$Pro_ID");    
                }
            }
            
        }
        else
        {
            $_SESSION['Msg'] = "The product is unvailable!";
            header("location: categories.php");
        }
        
    }
    else
    {
        $_SESSION['Msg'] = "Please Select Size Before Add to Cart!";
        header("location: products.php?title=$Pro_ID");    
    }
    

   
}

// Set total price of the product in the cart table
else if (isset($_POST['qty'])) {
  $qty = $_POST['qty'];
  $pid = $_POST['pid'];
  $pprice = $_POST['pprice'];

  $tprice = $qty * $pprice;

  $Change = "UPDATE cart SET qty='$qty',total_price = '$tprice' WHERE id = '$pid'" ;
  $Change_Run = mysqli_query($userconnection,$Change);
  
}
else if(isset($_POST['deleteItemBtn']))
{
    $Pro_ID = $_POST['pro_id'];
    $User_ID = $_POST['user_id'];
    $query = "DELETE FROM cart WHERE id = '$Pro_ID' and user_id = '$User_ID'";
    $query_run = mysqli_query($userconnection,$query);

    if($query_run)
    {
        $_SESSION['Msg'] = "The product had been deleted from the cart!";
        header("location: cart.php");    
    }
}

else if(isset($_POST['payment_method']))
{
    $User_ID = $_POST['user_id'];
    $FName = $_POST['fname'];
    $LName = $_POST['lname'];
    $Email = $_POST['email'];
    $Phone = $_POST['phone'];
    $Total = $_POST['gtotal'];
    $Address = $_POST['address'];
    $Payment_Method = $_POST['payment_method'];
    $Encryption_key = 'Multimedia'; 
    $iv = '1234567891234567';
    function encryption($data,$key,$iv)
    {
        $Encryption_key = base64_encode($key);
        $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
        return base64_encode($Encrypted_data . '::' . $iv);
    }
    $User_Encrypted_Email = encryption($Email, $Encryption_key, $iv);
    $User_Encrypted_Fname = encryption($FName, $Encryption_key, $iv);
    $User_Encrypted_Lname = encryption($LName, $Encryption_key, $iv);
    $User_Encrypted_Phone = encryption($Phone, $Encryption_key, $iv);
    $User_Encrypted_Address = encryption($Address, $Encryption_key, $iv);

    if($Payment_Method == "cod")
    {
        $Order = "INSERT INTO orders (user_id,fname,lname,email,phone,address,amount_paid,Status,payment_method) VALUES ('$User_ID','$User_Encrypted_Fname','$User_Encrypted_Lname','$User_Encrypted_Email','$User_Encrypted_Phone','$User_Encrypted_Address','$Total','0','$Payment_Method')";
        $Order_Run = mysqli_query($userconnection,$Order);
        if($Order_Run)
        {
            $Order_ID = mysqli_insert_id($userconnection);
            $Product = "SELECT * FROM cart WHERE user_id = '$User_ID'";
            $Product_run = mysqli_query($userconnection,$Product);
            if(mysqli_num_rows($Product_run) > 0)
            {
                foreach($Product_run as $data)
                {
                    $Size = $data['size'];
                    $Quantity = $data['qty'];
                    $Pro_ID = $data['product_id'];
                    $Pro = "SELECT * FROM product WHERE ID = '$Pro_ID'";
                    $Pro_Run = mysqli_query($dataconnection,$Pro);
                    if(mysqli_num_rows($Pro_Run)>0)
                    {   
                        $Order_Details = "INSERT INTO orders_details (Product_ID,Order_ID,Order_Size,Order_Quantity) VALUES ('$Pro_ID','$Order_ID','$Size','$Quantity')";
                        $Order_Details_Run = mysqli_query($userconnection,$Order_Details);
                        $Get_Stock = "SELECT * FROM stock WHERE Product_ID = '$Pro_ID' AND Product_Size ='$Size'";
                        $Get_Stock_Run = mysqli_query($dataconnection,$Get_Stock);
                        if(mysqli_num_rows($Get_Stock_Run)>0)
                        {
                            $Stock_Row = mysqli_fetch_array($Get_Stock_Run);
                            $qtty = $Stock_Row['Product_Quantity'];
                            $deduct_stock = $qtty - $Quantity;
                            $Update_Stock = "UPDATE stock SET Product_Quantity='$deduct_stock' WHERE Product_ID='$Pro_ID' AND Product_Size='$Size'";
                            $Update_Stock_Run = mysqli_query($dataconnection,$Update_Stock);   
                        }
                    } 
                }
            }
        }
        $clear_cart = "TRUNCATE TABLE cart";
        $clear_cart_run = mysqli_query($userconnection,$clear_cart);
        // Set session variables for invoice
        $_SESSION['order_id'] = $Order_ID;
        $_SESSION['email'] = $Email;
        $_SESSION['fname'] = $FName;
        $_SESSION['lname'] = $LName;
        $_SESSION['phone'] = $Phone;
        $_SESSION['gtotal'] = $Total;
        $_SESSION['address'] = $Address;

        header("Location: send_invoice.php");
    }
    else if ($Payment_Method == "card") 
    {
         $_SESSION['fname'] = $FName;
         $_SESSION['lname'] = $LName;
         $_SESSION['email'] = $Email;
         $_SESSION['phone'] = $Phone;
         $_SESSION['gtotal'] = $Total;
         $_SESSION['address'] = $Address;
        header("Location: card-payment.php");
        
    }
}
if(isset($_POST['paymentcardbtn'])) 
{
$FName = $_SESSION['fname'];
$LName = $_SESSION['lname'];
$Email = $_SESSION['email'];
$Phone = $_SESSION['phone'];
$Total = $_SESSION['gtotal'];
$Address = $_SESSION['address'];
$Card_Name = $_POST['name'];
$Card_Number = $_POST['number'];
$Card_Month = $_POST['month'];
$Card_Year = $_POST['year'];
$Card_CVV = $_POST['CVV'];
$Encryption_key = 'Multimedia'; 
$iv = '1234567891234567';
function encryption($data,$key,$iv)
{
    $Encryption_key = base64_encode($key);
    $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
    return base64_encode($Encrypted_data . '::' . $iv);
}

$encrypted_Card_Number = encryption($Card_Number, $Encryption_key, $iv);
$encrypted_Card_Month = encryption($Card_Month, $Encryption_key, $iv);
$encrypted_Card_Year = encryption($Card_Year, $Encryption_key, $iv);
$encrypted_Card_CVV = encryption($Card_CVV, $Encryption_key, $iv);
$encrypted_Card_Name = encryption($Card_Name, $Encryption_key, $iv);

$Check_Card = "SELECT * FROM card WHERE Card_Number='$encrypted_Card_Number'";
$Check_Card_Run = mysqli_query($userconnection, $Check_Card);

if (mysqli_num_rows($Check_Card_Run) > 0) {
        $Card_Row = mysqli_fetch_assoc($Check_Card_Run);
        if ($Card_Row['Card_Name'] != $encrypted_Card_Name || $Card_Row['Expiry_Month'] != $encrypted_Card_Month || $Card_Row['Expiry_Year'] != $encrypted_Card_Year || $Card_Row['Card_CVV'] != $encrypted_Card_CVV) {
            $_SESSION['message'] = "Card information does not match!";
            header("Location: card-payment.php");
            exit();
        }
    } else {
       
        $Insert_Card = "INSERT INTO card (Card_Name, Card_Number, Expiry_Month, Expiry_Year, Card_CVV) VALUES ('$encrypted_Card_Name', '$encrypted_Card_Number', '$encrypted_Card_Month', '$encrypted_Card_Year', '$encrypted_Card_CVV')";
        $Insert_Card_Run = mysqli_query($userconnection, $Insert_Card);
        if (!$Insert_Card_Run) {
            $_SESSION['message'] = "Failed to save card information!";
            header("Location: card-payment.php");
            exit();
        }
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $Card_Name)) {
        $_SESSION['message'] = "Invalid Name on Card!";
        header("Location: card-payment.php");
        exit();
    } else if (!preg_match("/^[0-9]{16}$/", $Card_Number)) {
        $_SESSION['message'] = "Invalid Card Number!";
        header("Location: card-payment.php");
        exit();
    } else if ($Card_Month < 1 || $Card_Month > 12 || $Card_Year < date('y')) {
        $_SESSION['message'] = "Invalid Expiry Date!";
        header("Location: card-payment.php");
        exit();
    } else if (!preg_match("/^[0-9]{3}$/", $Card_CVV)) {
        $_SESSION['message'] = "Invalid CVV!";
        header("Location: card-payment.php");
        exit();
    } else {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_phone'] = $Phone;

        $_SESSION['fname'] = $FName;
        $_SESSION['lname'] = $LName;
        $_SESSION['email'] = $Email;
        $_SESSION['phone'] = $Phone;
        $_SESSION['gtotal'] = $Total;
        $_SESSION['address'] = $Address;
        $_SESSION['card_name'] = $Card_Name;
        $_SESSION['card_number'] = $Card_Number;
        $_SESSION['card_month'] = $Card_Month;
        $_SESSION['card_year'] = $Card_Year;
        $_SESSION['card_cvv'] = $Card_CVV;

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
        $mail->addAddress($Email);     //Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment OTP Code';
        $mail->Body    = "Your OTP code is $otp";

        $mail->send();
        // Redirect to OTP verification page
        $_SESSION['message'] = "OTP Sent!";
        header("Location: verify-otp.php");
        exit();
    }
    
}

?>