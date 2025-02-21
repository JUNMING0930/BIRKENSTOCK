<?php include("dataconnection.php");?>
<?php $page_title = "Sign Up"?>
<?php include("includes/header.php") ?>
<style>
/* The message box is shown when the user clicks on the password field */
#message {
  display:none;

  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}

/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
</style>
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
						<p class="bread"><span><a href="index.php">Home</a></span> / <span>Sign Up</span></p>
					</div>
				</div>
			</div>
		</div>


		<div id="colorlib-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="contact-wrap">
							<h3>Sign Up</h3>
							<form action="signupcode.php" class="contact-form" method="POST">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="fname">First Name</label>
											<input type="text" required id="fname" name="fname" class="form-control" placeholder="Your firstname" onchange="check()">
											<span id="fnameerror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="lname">Last Name</label>
											<input type="text" required id="lname" name="lname" class="form-control" placeholder="Your lastname" onchange="check1()">
											<span id="lnameerror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="text" required id="email" name="email" class="form-control" placeholder="Your email address" onchange="check2()">
											<span id="emailerror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="subject">Password</label>
											<input type="password" style="height:45px" required id="password" name="password" class="form-control" placeholder="Your Password" onclick="check3()">
											<span id="passerror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
									<div id="message">
									<p>Password Requirement :</p>  
									<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
									<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
									<p id="number" class="invalid">A <b>number</b></p>
									<p id="special" class="invalid">A <b>special letter</b></p>
									<p id="length" class="invalid">Minimum <b>8 characters</b></p>
									</div>
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<label for="subject">Confirm Password</label>
											<input type="password"  style="height:45px" required id="cpassword" name="cpassword" class="form-control" placeholder="Your Confirm Password"  onchange="check4()">
											<span id="cpasserror" style="color: Red;text-align: center;"></span>
										</div>
									</div>
				
									<div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="submit" name="signupbtn" class="btn btn-primary" onclick="check5()">Join Us
										</div>
									</div>
                                    <div class="w-100"></div>
									<div class="col-sm-12">
										<div class="form-group">
                                                Already A Member?  <a href="login.php" style="font-weight: bold;text-decoration: underline;">Log In</a>
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
	
	<script type="text/javascript">
		var count1=0,count2=0,count3=0,count4=0,count5=0;
		function check()
		{
			var fname = document.getElementById("fname").value;
			var res = /^[a-zA-Z]+$/;
			if(res.test(fname))
			{
				document.getElementById("fnameerror").innerHTML = "";
			} 
			else
			{
				document.getElementById("fnameerror").innerHTML = "Please Enter Valid First Name";
			}
			
		}
		function check1()
		{
			var lname = document.getElementById("lname").value;
			var res = /^[a-zA-Z]+$/;
			if(res.test(lname))
			{
				document.getElementById("lnameerror").innerHTML = "";
			} 
			else
			{
				document.getElementById("lnameerror").innerHTML = "Please Enter Valid Last Name";
			}
		}
		function check2()
		{
			var email = document.getElementById("email").value;
			var ema = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(ema.test(email))
			{
				document.getElementById("emailerror").innerHTML = "";
			}
			else
			{
				document.getElementById("emailerror").innerHTML = "Please Enter Valid Email Address";
			}
		}
		function check3()
		{
			var Input = document.getElementById("password");
			var letter = document.getElementById("letter");
			var capital = document.getElementById("capital");
			var number = document.getElementById("number");
			var length = document.getElementById("length");
			var special = document.getElementById("special");
			document.getElementById("message").style.display = "block";
			Input.onkeyup = function() 
			{
			var lowerCaseLetters = /[a-z]/g;
			if(Input.value.match(lowerCaseLetters)) {  
				letter.classList.remove("invalid");
				letter.classList.add("valid");
			} else {
				letter.classList.remove("valid");
				letter.classList.add("invalid");
			}
			
			var upperCaseLetters = /[A-Z]/g;
			if(Input.value.match(upperCaseLetters)) {  
				capital.classList.remove("invalid");
				capital.classList.add("valid");
			} else {
				capital.classList.remove("valid");
				capital.classList.add("invalid");
			}

			var numbers = /[0-9]/g;
			if(Input.value.match(numbers)) {  
				number.classList.remove("invalid");
				number.classList.add("valid");
			} else {
				number.classList.remove("valid");
				number.classList.add("invalid");
			}
			
			if(Input.value.length >= 8) {
				length.classList.remove("invalid");
				length.classList.add("valid");
			} else {
				length.classList.remove("valid");
				length.classList.add("invalid");
			}

			if(Input.value.match(/[\'^£$%&*()}{@#~?><>,|=_+¬-]/)) {  
				special.classList.remove("invalid");
				special.classList.add("valid");
			} else {
				special.classList.remove("valid");
				special.classList.add("invalid");
			}
			}
		}
		function check4()
		{
			var cpassword = document.getElementById("cpassword").value;
			if(cpassword == document.getElementById("password").value)
			{
				document.getElementById("cpasserror").innerHTML = "";
			}
			else
			{
				document.getElementById("cpasserror").innerHTML = "The Confirm Password Is Not Same As Password!"
			}
		}
		
	</script>
	</body>
</html>

<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>