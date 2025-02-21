<?php
include("dataconnection.php");
$page_title = "OTP Verification";
session_start();


$Encryption_key = 'Multimedia'; 
$iv = '1234567891234567';


function encryption($data, $key, $iv) {
    $Encryption_key = base64_encode($key);
    $Encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $Encryption_key, 0, $iv);
    return base64_encode($Encrypted_data . '::' . $iv);
}

if (isset($_POST['verifyotpbtn'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        // OTP is correct, proceed with order placement
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);

        $FName = $_SESSION['fname'];
        $LName = $_SESSION['lname'];
        $Email = $_SESSION['email'];
        $Phone = $_SESSION['phone'];
        $Total = $_SESSION['gtotal'];
        $Address = $_SESSION['address'];
        $Payment_Method = 'Credit/Debit';
        $User_Encrypted_FName = encryption($FName, $Encryption_key, $iv);
        $User_Encrypted_LName = encryption($LName, $Encryption_key, $iv);
        $User_Encrypted_Email = encryption($Email, $Encryption_key, $iv);
        $User_Encrypted_Phone = encryption($Phone, $Encryption_key, $iv);
        $User_Encrypted_Address = encryption($Address, $Encryption_key, $iv);

        $User_ID = $_SESSION['ID'];

        $Order = "INSERT INTO orders (user_id, fname, lname, email, phone, address, amount_paid, Status, payment_method) VALUES ('$User_ID', '$User_Encrypted_FName', '$User_Encrypted_LName', '$User_Encrypted_Email', '$User_Encrypted_Phone', '$User_Encrypted_Address', '$Total', '0', '$Payment_Method')";
        $Order_Run = mysqli_query($userconnection, $Order);
        if ($Order_Run) {
            $Order_ID = mysqli_insert_id($userconnection);
            $Product = "SELECT * FROM cart";
            $Product_run = mysqli_query($userconnection, $Product);
            if (mysqli_num_rows($Product_run) > 0) {
                foreach ($Product_run as $data) {
                    $Size = $data['size'];
                    $Quantity = $data['qty'];
                    $Pro_ID = $data['product_id'];
                    $Pro = "SELECT * FROM product WHERE ID = '$Pro_ID'";
                    $Pro_Run = mysqli_query($dataconnection, $Pro);
                    if (mysqli_num_rows($Pro_Run) > 0) {
                        $Order_Details = "INSERT INTO orders_details (Product_ID, Order_ID, Order_Size, Order_Quantity) VALUES ('$Pro_ID', '$Order_ID', '$Size', '$Quantity')";
                        $Order_Details_Run = mysqli_query($userconnection, $Order_Details);
                        $Get_Stock = "SELECT * FROM stock WHERE Product_ID = '$Pro_ID' AND Product_Size ='$Size'";
                        $Get_Stock_Run = mysqli_query($dataconnection, $Get_Stock);
                        if (mysqli_num_rows($Get_Stock_Run) > 0) {
                            $Stock_Row = mysqli_fetch_array($Get_Stock_Run);
                            $New_Quantity = $Stock_Row['Product_Quantity'] - $Quantity;
                            $Update_Stock = "UPDATE stock SET Product_Quantity='$New_Quantity' WHERE Product_ID='$Pro_ID' AND Product_Size='$Size'";
                            mysqli_query($dataconnection, $Update_Stock);
                        }
                    }
                }
            }
            // Clear the cart
            $clear_cart = "TRUNCATE TABLE cart";
            mysqli_query($userconnection, $clear_cart);
            
            // Set session variables for invoice
            $_SESSION['order_id'] = $Order_ID;
            $_SESSION['email'] = $Email;
            $_SESSION['fname'] = $FName;
            $_SESSION['lname'] = $LName;
            $_SESSION['phone'] = $Phone;
            $_SESSION['gtotal'] = $Total;
            $_SESSION['address'] = $Address;

            header("Location: send_invoice.php");
            exit();
        } else {
            $_SESSION['message'] = "Failed to place order!";
            header("Location: card-payment.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid OTP!";
        header("Location: verify-otp.php");
        exit();
    }
}


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
                            <form action="verify-otp.php" class="contact-form" method="POST">
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