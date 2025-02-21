<?php $page_title = "Order History"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Cart</title>
	</head>
	<body>
		


		

    <form action="order-details.php" method="POST">
		<div class="colorlib-product">
			<div class="container">
					<h2>Order History</h2>
				<table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Order Date</th>
                      <th>Total</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                       $User_ID = $_SESSION['ID'];
                       $Order = "SELECT * FROM orders WHERE user_id = '$User_ID' ORDER BY id desc";
                       $Order_Run = mysqli_query($userconnection,$Order);
                       if(mysqli_num_rows($Order_Run) > 0)
                       {
                          foreach ($Order_Run as $items) 
                          {
                            ?>
                            <tr>
                              <td><?php echo $items['created_at'];?></td>
                              <td>RM <?php echo $items['amount_paid'];?></td>
                              <td>
                                <?php
                                if($items['payment_method'] == 'COD')
                                {
                                  echo "Cash On Delivery";
                                }
                                else
                                {
                                  echo "Credit/Debit Card";
                                }
                                ?>
                                </td>
                              <td>
                              <?php
                                if($items['Status'] == 0)
                                {
                                    echo "Packaging";
                                }
                                else if($items['Status'] == 1)
                                {
                                  echo "Shipping";
                                }
                                else if($items['Status'] == 2)
                                {
                                  echo "Delivered";
                                }
                                else if($items['Status'] == 3)
                                {
                                  echo "Canceled";
                                }
                                ?>
                              </td>
                              <td>
                              <button type="submit" name="order-history" value="<?php echo $items['id'];?>" class="btn btn-primary">View</button>
                              </td>
                            </tr>
                            <?php
                          }
                       }
                       else
                       {
                        ?>
                        <h5>No Records Found!</h5>
                        
                        <?php
                       }
				?>
                </tbody>
                </table>
                <div class="row row-pb-lg" style="height:250px">
		                    </div>
			</div>
		</div>
    </form>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
	</div>
	</body>
</html>
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>