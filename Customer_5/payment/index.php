<html>
<title>phpzag.com : Demo Razorpay Payment Gateway Integration in PHP</title>
<body>
<div class="container">
	<div class="row">		
		<div class="col-sm-12">	
			
			<div class="col-sm-4 col-lg-4 col-md-4">
				<div class="thumbnail">
					
					<div class="caption">
						<h4 class="pull-right">₹49.99</h4>
					

					</div>
					<form id="checkout-selection" action="pay.php" method="POST">		
						<input type="hidden" name="item_name" value="My Test Product">
						<input type="hidden" name="item_description" value="My Test Product Description">
						<input type="hidden" name="item_number" value="3456">
						<input type="hidden" name="amount" value="49.99">
						<input type="hidden" name="address" value="ABCD Address">
						<input type="hidden" name="currency" value="INR">	
						<input type="hidden" name="cust_name" value="rushil">								
						<input type="hidden" name="email" value="pipaliyarushil888@gmail.com">	
						<input type="hidden" name="contact" value="9725005862">								
						<input type="submit" class="btn btn-primary" value="Buy Now">					
					</form>						
				</div>
			</div>
		</div>
	</div>	
</div>
</body>
</html>