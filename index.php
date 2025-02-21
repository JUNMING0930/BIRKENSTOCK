<?php $page_title = "BIRKENSTOCK"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
<head>
 
    <style>
            .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 350px; /* Adjust the height to make the product box bigger */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow border */
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }

        .card-img-top {
            width: 100%;
            height: 250px; /* Adjust the height to make the image bigger */
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        .card-body {
            padding: 15px; /* Increase padding to make the card bigger */
        }

        .card-title {
            font-size: 16px; /* Increase font size to fit bigger card */
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 14px; /* Increase font size to fit bigger card */
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .partner-col {
            margin-bottom: 30px;
        }

        .partner-col img {
            max-width: 100%;
            height: auto;
            transition: all 0.3s ease;
        }

        .partner-col:hover img {
            transform: scale(1.1);
        }

        .gototop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .gototop a {
            display: block;
            width: 50px;
            height: 50px;
            background: #007bff;
            color: #fff;
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .gototop a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row ">
            <div class="col-sm-12 text-center">
                <h3 class="intro">Latest Product</h3>
            </div>
        </div>
        <div class="row mt-3">
            <?php
                $Product = "SELECT ID,Category_ID,Pro_Name,Pro_Price,Pro_Image FROM product WHERE Pro_Status = '1' ORDER BY ID DESC LIMIT 12";
                $Product_Run = mysqli_query($dataconnection,$Product);
                if(mysqli_num_rows($Product_Run) > 0)
                {
                    foreach($Product_Run as $Product_Items)
                    {
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <a href="products.php?title=<?php echo $Product_Items['ID']?>" class="prod-img">
                                    <img src="../Admin/uploads/products/<?php echo $Product_Items['Pro_Image']?>" class="card-img-top img-fluid" alt="Product Image">
                                </a>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><a href="products.php?title=<?php echo $Product_Items['ID']?>"><?php echo $Product_Items['Pro_Name']?></a></h5>
                                    <p class="card-text"><strong>RM <?php echo $Product_Items['Pro_Price']?></strong></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <p><a href="categories.php" class="btn btn-primary btn-lg">Shop All Products</a></p>
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