<?php include("dataconnection.php");?>
<?php $page_title = "Reset Password"?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Profile</title>
	</head>
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
    body{margin-top:20px;
    color: #9b9ca1;
    }
    .bg-secondary-soft {
        background-color: rgba(208, 212, 217, 0.1) !important;
    }
    .rounded {
        border-radius: 5px !important;
    }
    .py-5 {
        padding-top: 3rem !important;
        padding-bottom: 3rem !important;
    }
    .px-4 {
        padding-right: 1.5rem !important;
        padding-left: 1.5rem !important;
    }
    .file-upload .square {
        height: 250px;
        width: 250px;
        margin: auto;
        vertical-align: middle;
        border: 1px solid #e5dfe4;
        background-color: #fff;
        border-radius: 5px;
    }
    .text-secondary {
        --bs-text-opacity: 1;
        color: rgba(208, 212, 217, 0.5) !important;
    }
    .btn-success-soft {
        color: #28a745;
        background-color: rgba(40, 167, 69, 0.1);
    }
    .btn-danger-soft {
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }
    .form-control {
        display: block;
        width: 100%;
        padding: 0.5rem 1rem;
        font-size: 0.9375rem;
        font-weight: bold;
        line-height: 1.6;
        color: #29292e;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #e5dfe4;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 5px;
        -webkit-transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<div class="container">
<div class="row">
		<div class="col-12">
			<!-- Page title -->
			<div class="my-5">
				<h3>Reset Password</h3>
				<hr>
			</div>
			<!-- Form START -->
			<form class="file-upload" action="profilecode.php" method="POST">
				<div class="row mb-6 gx-5">
					<!-- Contact detail -->
					<div class="col-xxl-8 mb-5 mb-xxl-0">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row ">
                                <?php
                                if(isset($_GET['token']))
                                {
                                    $Token = $_GET['token'];
									$Get_Token = "SELECT * FROM user WHERE User_Token = '$Token'";
									$Get_Token_Run = mysqli_query($userconnection,$Get_Token);
									if(mysqli_num_rows($Get_Token_Run) > 0)
									{
										$Get_Token_Row = mysqli_fetch_array($Get_Token_Run);
										$User_ID = $Get_Token_Row['ID'];
												?>
										<!-- New Password -->
										<div class="col-md-8">
											<input type="hidden" name="user_token" value=<?php echo $Token ?>>
											<input type="hidden" name="user_id" value=<?php echo $User_ID ?>>
											<label class="form-label" style="font-weight:bold;color:black">New Password*</label>
											<input type="password" class="form-control" name="password" id="password" onclick="check()" placeholder="New Password" required>
										</div>
										<div class="col-md-4">
										</div>
										<div id="message">
											<p>Password Requirement :</p>  
											<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
											<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
											<p id="number" class="invalid">A <b>number</b></p>
											<p id="length" class="invalid">Minimum <b>8 characters</b></p>
										</div>
										<div class="col-md-12">
										</div>
										<!-- Confirm Password -->
										<div class="col-md-8">
											<label class="form-label" style="font-weight:bold;color:black">Confirm Password*</label>
											<input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password" required>
										</div>
									</div> <!-- Row END -->
								</div>
							</div>
							<?php
								/*
							<div class="col-xxl-4">
								<div class="bg-secondary-soft px-4 py-3 rounded">
									<div class="row g-3">
										<h4 class="mb-4 mt-0">Upload your profile photo</h4>
										<div class="text-center">
											<!-- Image upload -->
											<div class="square position-relative display-2 mb-3">
												<i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
											</div>
											<!-- Button -->
											<input type="file" id="customFile" name="file" hidden="">
											<label class="btn btn-success-soft btn-block" for="customFile">Upload</label>
											<button type="button" class="btn btn-danger-soft">Remove</button>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Row END -->
						*/
						?>
						<!-- button -->
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn-lg" name="resetpassbtn">Save</button>
						</div>
						<?php
						?>
					</form> <!-- Form END -->    
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
	
									}
									else
									{
										$_SESSION['message'] = "Invalid Token ,Please Try Again!";
										if(isset($_SESSION['message']))
										{
										$message = $_SESSION['message'];
										echo "<script>alert('$message')</script>";
										unset($_SESSION['message']);
										}
									}		
                                }
						
            ?>                    
<script type="text/javascript">
    function check()
    {
        var Input = document.getElementById("password");
			var letter = document.getElementById("letter");
			var capital = document.getElementById("capital");
			var number = document.getElementById("number");
			var length = document.getElementById("length");
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
</script>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>
