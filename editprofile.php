<?php $page_title = "Edit Profile"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Profile</title>
	</head>
    <style>
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
        font-weight: 400;
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
				<h3>Edit Profile</h3>
				<hr>
			</div>
			<!-- Form START -->
			<form action="profilecode.php" method="POST">
				<div class="row mb-6 gx-5">
					<!-- Contact detail -->
					<div class="col-xxl-8 mb-5 mb-xxl-0">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row ">
								<h4 class="col-md-12">Information</h4>
                                <?php
                                if(isset($_SESSION['ID']))
                                {
                                    $User_ID = $_SESSION['ID'];
                                    $User = "SELECT * FROM user WHERE ID = $User_ID";
                                    $User_Run = mysqli_query($userconnection,$User);
                                    $User_Info = mysqli_fetch_array($User_Run);
									$User_Email = decryption($User_Info['User_Email'], $Encryption_key);
									if($User_Info['User_Address'] != NULL)
									{
										$User_Address = decryption($User_Info['User_Address'], $Encryption_key);
									}
									else
									{
										$User_Address = "";
									}
									if($User_Info['User_Phone'] != NULL)
									{
										$User_Phone = decryption($User_Info['User_Phone'], $Encryption_key);
									}
									else
									{
										$User_Phone = "";
									}
                                }
                                ?>
								<!-- First Name -->
								<div class="col-md-3">
                                    <input type="hidden" name="user_id" value="<?php echo $User_Info['ID']?>">
									<label style="color:black;font-weight:bold" class="form-label">First Name *</label>
									<input type="text" name="fname" class="form-control"  value="<?php echo $User_Decrypted_Fname?>" aria-label="First name" required>
								</div>
								<!-- Last name -->
								<div class="col-md-3">
									<label style="color:black;font-weight:bold" class="form-label">Last Name *</label>
									<input type="text" name="lname" class="form-control"  value="<?php echo $User_Decrypted_Lname?>" aria-label="Last name" required>
								</div>
								<!-- Email -->
								<div class="col-md-12">
									<label style="color:black;font-weight:bold" for="form-label">Email *</label>
									<p>&nbsp&nbsp&nbsp<input type="email" size="50" name="email" style="border:none;background-color:rgba(208, 212, 217, 0)!important;" value="<?php echo $User_Email?>"></input></p>
								</div>
								<!-- Password -->
								<div class="col-md-6">
                                <label style="color:black;font-weight:bold" for=""><strong>Password</strong></label>
                                <p>&nbsp&nbsp&nbsp<input type="password" name="pass" style="border:none;background-color:rgba(208, 212, 217, 0)!important;" value="<?php echo $User_Info['User_Password']?>"></input>
                                <a href="editpass.php" class="btn me-5" style="font-weight:bold;">Edit</a></p>
								</div>
                                <div class="col-md-6">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Phone Number</label>
									<input type="text" name="phone" class="form-control" placeholder="Your Phone Number" value="<?php echo $User_Phone?>" required >
								</div>
								<div class="col-md-6">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Address</label>
									<p><textarea row="3" name="address" class="form-control" placeholder="Your Address" required><?php echo $User_Address?></textarea></p>
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
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary btn-lg" name="saveprobtn">Save</button>
					<a href="profile.php" class="btn btn-danger btn-lg">Return</a>
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
	?>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>
