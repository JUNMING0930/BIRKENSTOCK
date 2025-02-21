<?php
session_start();
include("dataconnection.php");
require_once 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function send_invoice($email, $invoice_content) {
    $mail = new PHPMailer(TRUE);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = "limjunming0930@gmail.com";                     //SMTP username
        $mail->Password   = "vmjkkzzrobmyaznz";                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom("limjunming0930@gmail.com", "BIRKENSTOCK");
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Your Order Invoice';
        $mail->Body    = $invoice_content;

        $mail->send();
        $_SESSION['message'] = "Order Placed Successfully. Invoice has been sent to your email.";
        unset($_SESSION['otp']);
    } catch (Exception $e) {
        $_SESSION['message'] = "Invoice could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_SESSION['order_id']) && isset($_SESSION['email'])) {
    $Order_ID = $_SESSION['order_id'];
    $Email = $_SESSION['email'];
    $FName = $_SESSION['fname'];
    $LName = $_SESSION['lname'];
    $Phone = $_SESSION['phone'];
    $Total = $_SESSION['gtotal'];
    $Address = $_SESSION['address'];

    $invoice_content = "<h1>Invoice</h1>";
    $invoice_content .= "<p>Name: $FName $LName</p>";
    $invoice_content .= "<p>Email: $Email</p>";
    $invoice_content .= "<p>Phone: $Phone</p>";
    $invoice_content .= "<p>Address: $Address</p>";
    $invoice_content .= "<p>Total: RM $Total</p>";
    $invoice_content .= "<h2>Order Details</h2>";
    $invoice_content .= "<table border='1'><tr><th>Product</th><th>Size</th><th>Quantity</th><th>Price</th></tr>";

    $Product = "SELECT * FROM orders_details WHERE Order_ID = '$Order_ID'";
    $Product_run = mysqli_query($userconnection, $Product);
    if (mysqli_num_rows($Product_run) > 0) {
        while ($data = mysqli_fetch_assoc($Product_run)) {
            $Pro_ID = $data['Product_ID'];
            $Size = $data['Order_Size'];
            $Quantity = $data['Order_Quantity'];
            $Pro = "SELECT * FROM product WHERE ID = '$Pro_ID'";
            $Pro_Run = mysqli_query($dataconnection, $Pro);
            if (mysqli_num_rows($Pro_Run) > 0) {
                $Pro_Data = mysqli_fetch_array($Pro_Run);
                $Pro_Name = $Pro_Data['Pro_Name'];
                $Pro_Price = $Pro_Data['Pro_Price'];
                $invoice_content .= "<tr><td>$Pro_Name</td><td>$Size</td><td>$Quantity</td><td>RM $Pro_Price</td></tr>";
            }
        }
    }
    $invoice_content .= "</table>";

    // Send the invoice
    send_invoice($Email, $invoice_content);

    // Clear session variables related to the order
    unset($_SESSION['order_id']);
    unset($_SESSION['email']);
    unset($_SESSION['fname']);
    unset($_SESSION['lname']);
    unset($_SESSION['phone']);
    unset($_SESSION['gtotal']);
    unset($_SESSION['address']);
    
    header("Location: order-complete.php");
    exit();
} else {
    $_SESSION['message'] = "Order details not found.";
    header("Location: cart.php");
    exit();
}

if(isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>