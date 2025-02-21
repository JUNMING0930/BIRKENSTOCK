<?php include("dataconnection.php");?>
<?php $page_title = "Forgot Password"?>
<?php include("includes/header.php") ?>
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
							<h3>Forgot Password</h3>
							<form action="emailresetcode.php" class="contact-form" method="POST">
								<div class="row">
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="email"><strong>Email Address</strong></label>
											<input type="email" required style="height:40px" id="email" name="email" class="form-control" placeholder="Your email address">
										</div>
									</div>
                                    <div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="passresetbtn" class="btn btn-primary">Send Email</a>
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
