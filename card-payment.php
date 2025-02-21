<?php include("dataconnection.php");?>
<?php $page_title = "Card Payment"?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Welcome to KNM Shoes</title>
</head>
<body>
    
<div class="colorlib-loader"></div>
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="index.php">Home</a></span> / <span>Payment</span></p>
            </div>
        </div>
    </div>
</div>

<div id="colorlib-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="contact-wrap">
                    <h3>Credit/Debit Card</h3>
                    <form action="cartcode.php" class="contact-form" method="POST">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="hidden" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                                    <input type="hidden" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                                    <input type="hidden" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                    <input type="hidden" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                                    <input type="hidden" name="gtotal" value="<?php echo isset($_POST['gtotal']) ? $_POST['gtotal'] : ''; ?>">
                                    <textarea name="address" hidden><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                                    <label for="name">Name On Card*</label>
                                    <input type="text" required id="name" name="name" class="form-control" placeholder="Name" oninput="validateForm()">
                                    <span id="nameerror" style="color:Red;text-align:center;"></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Card Number*</label>
                                    <input type="text" required id="number" name="number" class="form-control" placeholder="Number" oninput="validateForm()" maxlength="16" size="16">
                                    <span id="numbererror" style="color: Red;text-align: center;"></span>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="subject">Expiry Date</label>
                                    <span class="expiration">
                                        <select name="month" required style="height:45px;border:none" oninput="validateForm()">
                                            <option value="">MM</option>
                                            <?php for($m=1; $m<=12; $m++): ?>
                                                <option value="<?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($m, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <span>/</span>
                                        <select name="year" required style="height:45px;border:none" oninput="validateForm()">
                                            <option value="">YY</option>
                                            <?php for($y=date('y'); $y<=date('y')+10; $y++): ?>
                                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="subject">CVV</label>
                                    <input type="password" maxlength="3" style="height:45px" required id="CVV" name="CVV" class="form-control" placeholder="CVV" oninput="validateForm()">
                                    <span id="cvverror" style="color: Red;text-align: center;"></span>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" id="paymentButton" name="paymentcardbtn" class="btn btn-primary" disabled>Proceed</button>
                                </div>
                            </div>
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if(isset($_SESSION['message']))
{
    $message = $_SESSION['message'];
    echo "<script>alert('$message')</script>";
    unset($_SESSION['message']);
}
?>
<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
</div>

<script>
function validateForm() {
    var name = document.getElementById("name").value;
    var number = document.getElementById("number").value;
    var month = document.getElementsByName("month")[0].value;
    var year = document.getElementsByName("year")[0].value;
    var cvv = document.getElementById("CVV").value;

    var nameValid = /^[a-zA-Z\s]+$/.test(name);
    var numberValid = /^[0-9]{16}$/.test(number);
    var monthValid = /^[0-9]{2}$/.test(month) && month >= 1 && month <= 12;
    var yearValid = /^[0-9]{2}$/.test(year) && year >= new Date().getFullYear() % 100;
    var cvvValid = /^[0-9]{3}$/.test(cvv);

    document.getElementById("nameerror").innerHTML = nameValid ? "" : "Please Enter Valid Name";
    document.getElementById("numbererror").innerHTML = numberValid ? "" : "Please Enter Valid Card Number";
    document.getElementById("cvverror").innerHTML = cvvValid ? "" : "Please Enter Valid CVV";

    document.getElementById("paymentButton").disabled = !(nameValid && numberValid && monthValid && yearValid && cvvValid);
}
</script>
</body>
</html>

<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>