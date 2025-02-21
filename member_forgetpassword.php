<?php include("userconnection.php");?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <title>Cellucity Forget Password</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="../assets/css/login_style.css">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Forget Password</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/owl.css">
	
	<style>
		.nav-item:hover
		{
			cursor:pointer;
		}
		header .container img
		{
			height:75px;
			width:75px;
			margin-bottom:-15px;
		}
			
		.distance
		{
			margin-top:150px;
		}
		form
		{
			height:600px;
		}
		.forgot-pass 
		{
			margin-top: 15px;
			text-align: center;
			font-size: 12px;
			color: #cfcfcf;
		}
		input[type=submit]
		{
			background-color:#3CB371;
			transition-duration: 0.5s;
			color:white;
		}
		.img_text-color
		{
			color:snow;
			opacity:0.7;
		}
		input[type=submit]:hover
		{
			background-color:yellowgreen;
		}
	
		label span
		{
			font-size:15px;
		}
		a:hover
		{
			color:yellowgreen;
		}
		
		.distance-label
		{
			margin-left:20px;
		}
		
		.center-label
		{
			margin-left:160px;
		}
		
		#empty
		{
			display:inline-block;
			color:red;
			font-size:9px;
			text-transform:capitalize;
		}
	</style>
</head>

<body>

<!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
              <li><a href="mailto:cellucity.fyp@gmail.com"><i class="fa fa-envelope"></i>cellucity.fyp@gmail.com</a></li>
              <li><a href="tel:0112589774"><i class="fa fa-phone"></i>011-2589774</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="https://www.facebook.com/CellucityFyp-100538958705196"target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/Cellucity1"target="_blank"><i class="fa fa-twitter"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
<header>
<div style="background-color:black;">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a href="index.php"><img src="../assets/images/cellucity_logo.png"> <div class="navbar-brand"><h2>Mobile Phone <em>E-Store</em></h2></a></div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Brand</a>
                <div class="dropdown-menu">
				<?php 
				$sql="SELECT * from brand WHERE Brand_Status=0";
				$result = mysqli_query($connect,$sql);
				
				while($row=mysqli_fetch_assoc($result))
				{
				?>
                    <a class="dropdown-item" href="brand_listed_prod.php?id=<?php echo $row["Brand_ID"];?>"><?php echo $row["Brand_Name"];?></a>
                <?php
				}
				?>
				</div>
              </li>
			   <?php 
				if(isset($_SESSION['user_id']))
				{
					?>
			  <li class="nav-item">
                <a class="nav-link" href="member_cart.php">Checkout</a>
              </li>
				<?php
				}
				?>
				
			  <li class="nav-item">
                <a class="nav-link" href="about.php">About Us</a>
              </li>
			  <?php
			  if(!isset($_SESSION['username']))
				{

			   ?>
			  <li class="nav-item active">
                <a class="nav-link" href="login.php">Account</a>
              </li>
			  <?php
				}
				
			  else
			  {
			  ?>
			  <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Hi, <?php echo $_SESSION['username'];?></a>
                <div class="dropdown-menu">
				 <a class="dropdown-item" href="member_profile.php">Profile</a>
				 <a class="dropdown-item" href="member_history.php">Order History</a>
				 <a class="dropdown-item" href="logout.php" onclick="return confirm('Do you want to log out?');">Log Out</a>
				</div>
			   </li>
			   <?php
			  }
			  ?>
			<li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
<div class="distance">
<form name="forget_password" method="post" style="margin-top:100px;" action="memberpassword_check.php">
<div class="cont">
  <div style="text-align:center;">
    <h2 style="margin-top:25px;">Forget Password?</h2>
	<br>
	<h4>Let us help you...</h4><br>
	Type your username and email here. We will send you an email&nbsp!<br>
    <label>
      <span>Username</span>
      <input type="text" name="Mem_Forget_Username" required>
    </label>
	<br>
    <label>
      <span>Email</span>
      <input type="text" name="Mem_Forget_Email" required>
    </label>
    <p class="remember-pass"><a href="login.php">Already Remember?<a></p>
    <input type="submit" class="submit" name="send_btn" value="Reset Password" style="display: block;margin: 0 auto;margin-top:20px;width: 260px;height: 36px;border-radius: 30px;color: #fff;font-size: 15px;cursor: pointer;">
  </div>
 </div>
</form>
</div>

    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/owl.js"></script>
    <script src="../assets/js/slick.js"></script>
    <script src="../assets/js/accordions.js"></script>
	<script src="../assets/js/login_required.js"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>
	

</body>
</html>

