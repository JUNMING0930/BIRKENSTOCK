<?php include("dataconnection.php");?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">BIRKENSTOCK</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="categories.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Shop
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $Category = "SELECT * FROM category WHERE Cate_Status = '1'";
                        $Category_Query = mysqli_query($dataconnection,$Category);
                        if(mysqli_num_rows($Category_Query) > 0)
                        {
                            foreach($Category_Query as $Items)
                            {
                                ?>
                                <a class="dropdown-item" href="categories.php?cate=<?php echo $Items["Cate_Name"]?>"><?php echo $Items["Cate_Name"]?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="categories.php" method="GET">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="icon-search"></i></button>
            </form>
            <ul class="navbar-nav ml-auto">
                <?php
                if(isset($_SESSION['ID']))
                {
                    $User_ID = $_SESSION['ID'];
                    $Cart = "SELECT * FROM cart WHERE user_id = '$User_ID'";
                    $Cart_run = mysqli_query($userconnection,$Cart);
                    $Cart_Amount = mysqli_num_rows($Cart_run);
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="icon-shopping-cart"></i> Cart [<?= $Cart_Amount ?>]</a>
                    </li>
                    <?php
                }
                else
                {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="icon-shopping-cart"></i> Cart [0]</a>
                    </li>
                    <?php
                }
                ?>
                <?php
                if(isset($_SESSION['ID']))
                {
                    
                    $Encryption_key = 'Multimedia'; 
                    $iv = '1234567891234567';
                    function decryption($data, $key)
                    {
                        $decryption_key = base64_encode($key);
                        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
                        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $decryption_key, 0, $iv);
                    }
                    
                    $User_ID = $_SESSION['ID'];
                    $User = "SELECT * FROM user WHERE ID = $User_ID";
                    $User_Run = mysqli_query($userconnection,$User);
                    $User_Info = mysqli_fetch_array($User_Run);

                    $User_FName = $User_Info['User_First_Name']; 
                    $User_Lname = $User_Info['User_Last_Name'];
                    $User_Decrypted_Fname = decryption($User_FName, $Encryption_key);
                    $User_Decrypted_Lname = decryption($User_Lname, $Encryption_key);
                    $User_Name = $User_Decrypted_Fname . " " . $User_Decrypted_Lname;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="order-history.php"><i class="icon-truck"></i> Order History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Welcome, <?php echo $User_Name?> </a>
                    </li>
                    <?php
                }
                else
                {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login/Sign up</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
