<?php $page_title = "Cart"?>
<?php include("dataconnection.php");?>
<?php include("includes/header.php") ?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Cart</title>
	</head>
	<body>
	<?php
	if(isset($_SESSION['ID']))
	{

	?>
	<div class="colorlib-loader"></div>


		

		<div class="colorlib-product">
			<div class="container">
				<div class="row row-pb-lg">
					<div class="col-md-10 offset-md-1">
						<div class="process-wrap">
							<div class="process text-center active">
								<p><span>01</span></p>
								<h3>Shopping Cart</h3>
							</div>
							<div class="process text-center">
								<p><span>02</span></p>
								<h3>Checkout</h3>
							</div>
							<div class="process text-center">
								<p><span>03</span></p>
								<h3>Order Complete</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-pb-lg">
					<div class="col-md-12">
						<div class="product-name d-flex">
							<div class="one-forth text-left px-4">
								<span>Product Details</span>
							</div>
							<div class="one-eight text-center">
								<span>Price</span>
							</div>
							<div class="one-eight text-center">
								<span>Quantity</span>
							</div>
							<div class="one-eight text-center">
								<span>Size</span>
							</div>
                            <div class="one-eight text-center">
								<span>Total</span>
							</div>
							<div class="one-eight text-center px-4">
								<span>Remove</span>
							</div>
						</div>
                        <div>
                        <p> 
						<?php
						if(isset($_SESSION['Msg']))
						{
							$Msg = $_SESSION['Msg'];
							echo "<strong>$Msg</strong>";
                            unset($_SESSION['Msg']);
						}
						?>
						</p>
                        </div>
                        <?php
						if(isset($_SESSION['ID']))
						{
							$ID = $_SESSION['ID'];
							$cart = "SELECT * FROM cart WHERE user_id = '$ID'";
							$cart_run = mysqli_query($userconnection,$cart);
							$ptotal=  0;
							$total = 0;
							$gtotal = 0;
							if(mysqli_num_rows($cart_run) > 0)
							{
								$Num_Items = mysqli_num_rows($cart_run);

								$_SESSION['Items'] = $Num_Items;
								foreach($cart_run as $data)
								{
								?>
								<div class="product-cart d-flex">
									<div class="one-forth">
										<input type="hidden" class="pid" name="pro_id" value="<?php echo $data['id']?>">
										<?php
										$Size = $data['size'];
										$Pro_ID = $data['product_id'];
										$Product = "SELECT * FROM product WHERE ID='$Pro_ID'";
										$Product_Run = mysqli_query($dataconnection,$Product);
										if(mysqli_num_rows($Product_Run) > 0)
										{
											$Pro_Row = mysqli_fetch_array($Product_Run);
										}
										(float)$ptotal = (float)$Pro_Row['Pro_Price'] * (float)$data['qty'];	
										?>
										<div class="product-img" style="background-image: url(../Admin/uploads/products/<?php echo $Pro_Row['Pro_Image']?>);">
										</div>
										<div class="display-tc">
											<h3><?php echo $Pro_Row['Pro_Name']?></h3>
										</div>
									</div>
									<div class="one-eight text-center">
										<div class="display-tc">
											<input type="hidden" class="pprice" value="<?php echo $Pro_Row['Pro_Price']?>"> RM <?php echo $Pro_Row['Pro_Price']?></input>
										</div>
									</div>
									<div class="one-eight text-center">
										<div class="display-tc">
											<?php
											$Max = "SELECT * FROM stock WHERE Product_ID = '$Pro_ID' AND Product_Size = '$Size'" ;
											$Max_run = mysqli_query($dataconnection,$Max);
											if(mysqli_num_rows($Max_run) > 0)
											{
												$Max_Size = mysqli_fetch_array($Max_run);
											}
											?>
											<input type="number" id="quantity" name="quantity" onKeyDown="return false" class="form-control input-number text-center itemQty" value="<?php echo $data['qty']?>" min="1" max="<?php echo $Max_Size['Product_Quantity']?>">
											<input type="hidden" class="pprice" value="<?php echo $Pro_Row['Pro_Price']?>"></input>
											<input type="hidden" class="pid" name="pro_id" value="<?php echo $data['id']?>">
										</div>
									</div>
									<div class="one-eight text-center">
										<div class="display-tc">
											<span class="size"><?php echo $data['size']?></span>
										</div>
									</div>
									<div class="one-eight text-center">
										<div class="display-tc">
										<input type="hidden" name="ptotal" value="<?php echo number_format((float)$ptotal, 2, '.', '')?>"> RM <?php echo number_format((float)$ptotal, 2, '.', '')?></input>
										</div>
									</div>
									<form action="cartcode.php" method="POST">
									<div class="one-eight text-center">
										<div class="display-tc">
											<input type="hidden" class="pid" name="pro_id" value="<?php echo $data['id']?>">
											<input type="hidden" class="uid" name="user_id" value="<?php echo $ID?>">
											<button type="submit" onclick="return confirm('Are you sure to delete this item?')" name="deleteItemBtn" class="closed" style="border:none;cursor:pointer"></button>
										</div>
									</div>
									</form>
								</div>
								<?php
								$total += $ptotal;
								}
							
							}
							else
							{
								?>
								<div style="margin-left:400px">
								<h2>Nothing inside the cart!</h2>
								<a href="categories.php" class="btn btn-danger" style="margin-left:100px">Browse Item</a>
								</div>
							</div>
								<?php
							}
						}
						
                        ?>
					</div>
				</div>
				<div class="row row-pb-lg">
					<div class="col-md-12">
						<div class="total-wrap">
							<div class="row">
                                <div class="col-sm-4 text-center">
									
										<?php
											if($total > 0)
											{
												?>
												<div class="total">
												<div class="sub">
											<p><span>Subtotal:</span> <span>RM <?php echo number_format((float)$total, 2, '.', '')?></span></p>
                                            <p><span>Shipping:</span> <span>RM 10.00</span></p>
										</div>
										<div class="grand-total">
                                            <?php
                                            $gtotal = $total+10;
                                            ?>
											<p><span><strong>Total:</strong></span> <span>RM <?php echo number_format((float)$gtotal, 2, '.', '')?></span></p>
										</div>
									</div>
								</div>
								<div class="col-sm-8">
									<form action="checkout.php" method="POST">
										<div class="row form-group">
											<div class="col-sm-9">
                                                <input type="hidden" name="total" value=<?php echo $total?>>
												<input type="submit" onclick="return confirm('Are you sure to checkout?')"name="checkooutbtn"value="Checkout" class="btn btn-primary">
											</div>
										</div>
									</form>
								</div>
												<?php
											}
											else
											{
											?>
												
								<?php
											}
										?>
										
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
	</div>
	</body>
</html>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
<script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('div');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'cartcode.php',
        method: 'POST',
        cache: false,
        data: 
		{
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>	
  
  <?php
	}
	else
	{
		$_SESSION['message'] = "Please Log In Before viewing cart!";
		if(isset($_SESSION['message']))
		{
		$message = $_SESSION['message'];
		echo "<script>alert('$message')</script>";
		unset($_SESSION['message']);
		}
		?>
		<div class="colorlib-loader"></div>
<div class="colorlib-product">
	<div class="container">
		<div class="row row-pb-lg">
			<div class="col-md-10 offset-md-1">
				<div class="process-wrap">
					<div class="process text-center active">
						<p><span>01</span></p>
						<h3>Shopping Cart</h3>
					</div>
					<div class="process text-center">
						<p><span>02</span></p>
						<h3>Checkout</h3>
					</div>
					<div class="process text-center">
						<p><span>03</span></p>
						<h3>Order Complete</h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row row-pb-lg">
			<div class="col-md-12">
				<div class="product-name d-flex">
					<div class="one-forth text-left px-4">
						<span>Product Details</span>
					</div>
					<div class="one-eight text-center">
						<span>Price</span>
					</div>
					<div class="one-eight text-center">
						<span>Quantity</span>
					</div>
					<div class="one-eight text-center">
						<span>Size</span>
					</div>
					<div class="one-eight text-center">
						<span>Total</span>
					</div>
					<div class="one-eight text-center px-4">
						<span>Remove</span>
					</div>
				</div>
				<div>
				<p> 
				<?php
				if(isset($_SESSION['Msg']))
				{
					$Msg = $_SESSION['Msg'];
					echo "<strong>$Msg</strong>";
					unset($_SESSION['Msg']);
				}
				?>
				</p>
				</div>
		<div style="margin-left:300px">
		<h2>Please Log In Before Viewing Cart!</h2>
		<a href="login.php" class="btn btn-danger" style="margin-left:200px">Login</a>
		</div>
		<div class="row row-pb-lg" style="height:250px">
		</div>
		<?php					
		
	}
  ?>	
<?php include("includes/footer.php")?>
<?php include("includes/scripts.php")?>