<?php $page_title = "Login"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
	<head>
	
	</head>
	<body>
	<div class="colorlib-loader"></div>


		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col">
						<p class="bread"><span><a href="index.php">Home</a></span> / <span>Login</span></p>
					</div>
				</div>
			</div>
		</div>


		<div id="colorlib-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="contact-wrap">
							<h3>Login</h3>
							<form action="logincode.php" class="contact-form" method="POST">
								<div class="row">
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="text" id="email" name="email" class="form-control" placeholder="Your email address" onchange="check1()">
                                            <span id="emailerror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="subject">Password</label>
											<input type="password" style="height:40px"id="password" name="password" class="form-control" placeholder="Your Password">
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
                                            <a href="forgotpassword.php" style="font-weight: bold;">Forgotten your password?</a>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="loginbtn" class="btn btn-primary">Log In</a>
										</div>
									</div>
                                    <div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
                                            Not A Member?  <a href="sign-up.php" style="font-weight: bold;text-decoration: underline;">Join us</a>
										</div>
									</div>
									<div class="w-100"></div>
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

    <script type="text/javascript">
        var count =0;
        function check1()
        {
            var email = document.getElementById("email").value;
			var ema = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(ema.test(email))
			{
				document.getElementById("emailerror").innerHTML = "";
                count = 1;
			}
			else
			{
				document.getElementById("emailerror").innerHTML = "Please Enter Valid Email Address";
			}
        }

		
    </script>

	</body>
</html>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>
