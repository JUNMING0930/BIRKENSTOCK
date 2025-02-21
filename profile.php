<?php $page_title = "Profile"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<?php include("security.php");?>
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
    .form-control 
	{
        width: 100%;
        padding: 0.5rem 1rem;
        font-size: 0.9375rem;
        font-weight: 800;
        line-height: 1.6;
        color: black;
        background-color: #9b9ca1;
        border:0px;
        border-radius: 0px;
    }
    </style>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Profile</title>
	</head>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<div class="container">
<div class="row">
		<div class="col-12">
			<!-- Page title -->
			<div class="my-5">
				<h3>My Profile</h3>
				<hr>
			</div>
			<!-- Form START -->
			<form action="profilecode.php" method="POST">
				<div class="row mb-6 gx-5">
					<!-- Contact detail -->
					<div class="col-xxl-8 mb-5 mb-xxl-0">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row g-3">
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
								
								?>
								<!-- First Name -->
								<div class="col-md-6">
									<input type="hidden" name="user_id" value=<?php echo $User_Info['ID']?>>
									<label style="color:black;font-weight:bold" class="form-label">First Name *</label>
									<p style="color:black;"><strong><?php echo $User_Decrypted_Fname?></strong></p>
								</div>
								<!-- Last name -->
								<div class="col-md-6">
									<label style="color:black;font-weight:bold" class="form-label">Last Name *</label>
									<p style="color:black;" ><strong><?php echo $User_Decrypted_Lname?></strong></p>
								</div>
								<!-- Email -->
								<div class="col-md-12">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Email *</label>
									<p style="color:black;"><strong><?php echo $User_Email?></strong></p>
								</div>
								<div class="col-md-6">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Password *</label>
									<p><input type="password" style="border:none;background-color:rgba(208, 212, 217, 0)!important;" value="<?php echo $User_Info['User_Password']?>"></input></p>
								</div>
								<div class="col-md-6">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Phone Number</label>
									<p style="color:black;">
									<?php 
									if($User_Info['User_Phone'] == NULL) 
									{
										echo "";
									}
									else
									{
										echo $User_Phone;
									}
									?>
									</p>
								</div>
								<div class="col-md-6">
									<label style="color:black;font-weight:bold" for="form-label" class="form-label">Address</label>
									<p><textarea readonly style="border:none;background-color:rgba(208, 212, 217, 0)!important;"><?php echo $User_Address?></textarea></p>
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
            	</form> <!-- Form END -->    
				<div class="gap-3 d-md-flex justify-content-md-end text-center">
					<a href="editprofile.php" class="btn btn-primary btn-lg"  style="height:60px">Update profile</a>
                    <a href="index.php" class="btn btn-danger btn-lg" style="height:60px">Return</a>
                    <form action="logout.php" method="POST">
                        <button type="submit" onclick="confirm('Are you sure you want to logout?')" name="logout" class="btn btn-secondary btn-lg">Log out</button>
                    </form>
				</div>
				<?php
								}
								?>
		</div>
	</div>
	</div>





















<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>
