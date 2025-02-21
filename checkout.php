<?php $page_title = "Checkout"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    
<div class="colorlib-loader"></div>

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Home</a></span> / <span>Checkout</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product">
    <div class="container">
        <div class="row row-pb-lg">
            <div class="col-sm-10 offset-md-1">
                <div class="process-wrap">
                    <div class="process text-center active">
                        <p><span>01</span></p>
                        <h3>Shopping Cart</h3>
                    </div>
                    <div class="process text-center active">
                        <p><span>02</span></p>
                        <h3>Checkout</h3>
                    </div>
                    <div class="process text-center">
                        <p><span>03</span></p>
                        <h3>Order Complete</h3>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($_SESSION['ID']))
        {
            $ID = $_SESSION['ID'];
            $Encryption_key = 'Multimedia'; 
            $iv = '1234567891234567';
            $User_Info = "SELECT * FROM user WHERE ID = '$ID'";
            $User_Info_run = mysqli_query($userconnection,$User_Info);
            if(mysqli_num_rows($User_Info_run) > 0)
            {
                $User = mysqli_fetch_array($User_Info_run);
                $User_Fname = decryption($User['User_First_Name'], $Encryption_key);
                $User_Lname = decryption($User['User_Last_Name'], $Encryption_key);
                $User_Email = decryption($User['User_Email'], $Encryption_key);
                if($User['User_Address'] != NULL)
                {
                    $User_Address = decryption($User['User_Address'], $Encryption_key);
                }
                else
                {
                    $User_Address = "";
                }
                if($User['User_Phone'] != NULL)
                {
                    $User_Phone = decryption($User['User_Phone'], $Encryption_key);
                }
                else
                {
                    $User_Phone = "";
                }
            }
        ?>
        <form id="checkoutForm" action="cartcode.php" method="POST">
            <div class="row">
                <div class="col-lg-8">
                    <h2>Billing Details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $ID?>">
                                <label style="color:black;font-weight:bold" for="fname">First Name</label>
                                <input style="font-weight:bold" type="text" name="fname" class="form-control" placeholder="Your firstname" value="<?php echo $User_Fname?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:black;font-weight:bold" for="lname">Last Name</label>
                                <input style="font-weight:bold" type="text" name="lname" class="form-control" placeholder="Your lastname" value="<?php echo $User_Lname?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="color:black;font-weight:bold" for="address">Address</label>
                                <textarea rows="3" style="font-weight:bold" name="address" class="form-control" placeholder="Enter Your Address" required><?php echo $User_Address?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:black;font-weight:bold" for="email">E-mail Address</label>
                                <input style="border:none;font-weight:bold" type="email" readonly name="email" class="form-control" placeholder="Your Email" value="<?php echo $User_Email?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:black;font-weight:bold" for="phone">Phone Number</label>
                                <input style="font-weight:bold" type="text" name="phone" class="form-control" required placeholder="Your Phone Number" value="<?php echo $User_Phone?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_POST['total']))
                {
                    $total = $_POST['total'];
                    $gtotal = $total + 10;
                ?>              
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cart-detail">
                                <h2>Order Summary</h2>
                                <ul>
                                    <?php
                                    $ID = $_SESSION['ID'];
                                    $Cart_Info = "SELECT * FROM cart WHERE user_id = '$ID'";
                                    $Cart_Info_Run = mysqli_query($userconnection,$Cart_Info);
                                    if(mysqli_num_rows($Cart_Info_Run) > 0)
                                    {
                                        foreach($Cart_Info_Run as $Cart)
                                        {
                                            $Pro_ID = $Cart['product_id'];
                                            $Product = "SELECT * FROM product WHERE ID='$Pro_ID'";
                                            $Product_Run = mysqli_query($dataconnection,$Product);
                                            if(mysqli_num_rows($Product_Run) > 0)
                                            {
                                                $Pro_Row = mysqli_fetch_array($Product_Run);
                                                $Pro_Total = $Cart['qty'] * $Pro_Row['Pro_Price'];
                                            }
                                            ?>
                                            <li><span><?php echo $Cart['qty']?>x <?php echo $Pro_Row['Pro_Name']?></span><span>RM <?php echo number_format((float)$Pro_Total, 2, '.', '')?></span></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <li>
                                        <span>Subtotal</span> <span>RM <?php echo number_format((float)$total, 2, '.', '')?></span>
                                    </li>
                                    <li><span>Shipping</span> <span>RM 10.00</span></li>
                                    <li><span>Order Total</span> <span>RM <?php echo number_format((float)$gtotal, 2, '.', '')?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="cart-detail">
                                <h2>Payment Method</h2>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="hidden" name="gtotal" value="<?php echo $gtotal; ?>">
                                        <button type="submit" name="payment_method" value="cod" class="btn btn-primary">Cash On Delivery</button>
                                        <button type="submit" name="payment_method" value="card" class="btn btn-secondary">Pay with Credit Card</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </form>
        <?php
        }
        ?>
    </div>
</div>  
<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
</div>
<script>
document.getElementById('cardPaymentBtn').addEventListener('click', function() {
    var form = document.getElementById('checkoutForm');
    form.action = 'card-payment.php';
    form.method = 'POST';
    form.submit();
});
</script>
</body>
</html>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>