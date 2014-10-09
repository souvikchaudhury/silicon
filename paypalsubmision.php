<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Index | Silikon Graphics</title>

	<!-- styles -->
	<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'> -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" id="switch_style" href="black.css"> 

	<!-- Scripts  -->
	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/core.js"></script>
	<script>
		$(document).ready(function() {
			$('.box').click(function() {
				$(this).parent('.orderInfo').find('.popUpBox').fadeIn('800')
			});
			
			$('.closeBtn').click(function(){
				$(this).parent('.popUpBox').fadeOut('800');
			});

			$('.showEdit').click(function() {
				$(this).next(".editBox").fadeToggle();
				$(this).toggleClass('active');
			});

			$('.userMenu ul li a').click(function() {
				$(this).toggleClass('active').next().fadeIn('800');
			});

			$('.userMenuOptions .closeBtn').click(function() {
				$(this).parent().fadeOut('800').prev().removeClass('active');
			});
			//
			$("input[type='radio']").click(function()
				{
			  var previousValue = $(this).attr('previousValue');
			  var name = $(this).attr('name');

			  if (previousValue == 'checked')
			  {
			    $(this).removeAttr('checked');
			    $(this).attr('previousValue', false);
			  }
			  else
			  {
			    $("input[name="+name+"]:radio").attr('previousValue', false);
			    $(this).attr('previousValue', 'checked');
			  }
			});
			//
			$('.infoProduction').click(function() {
				$(this).prev('.production').toggleClass('redBg');	
			});
			$('.infoComplete').click(function() {
				$(this).prev('.complete').toggleClass('greenBg');	
			});
		});
	</script>

</head>
<body>
	<!-- header start -->
	<div class="header">  
		<div class="wrapper">
			<div class="logo">
				<a href="index.html"><img src="images/logo.png" alt=""></a>
			</div>
			<div class="nav">
				<ul>
					<li class="active print2u"><a href="#">Print 2 you</a></li>
					<li class="active user"><a href="#">Welcome Aldrich</a></li>
					<li class="right signOut"><a href="#">Sign out</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- header end -->
	
	<!-- mainBody Start -->
	<div class="mainBody">
		<div class="wrapper">
			<div class="contentArea">
				<div class="paypalPaymentFront">
					<div class="billingInfo">
						<div class="popColWrap">
							<h2>Total $29.90 AUD</h2>
							<h3>Your Order summary from Aldrich Qual Hol</h3>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<th>Decription </th>
										<th>Amount </th>
									</tr>
								</thead>
							    <tbody>
							      <tr>
							        <td align="left" valign="middle"><strong class="underLine">1 x  Benzima Red</strong>Item Price : $29.90 Quantity 1</td>
							        <td align="left" valign="middle"><strong>$29.90</strong></td>
							      </tr>
							    </tbody>
							</table>

							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="totalPrice">
								<tbody>
							      <tr>
							        <td align="left" valign="middle"><strong>Item total</strong></td>
							        <td align="left" valign="middle"><strong>$29.90</strong></td>
							      </tr>
							   </tbody>
							</table>

							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							    <tbody>
							      <tr>
							        <td align="left" valign="middle"></td>
							        <td align="left" valign="middle"><strong>Total $29.90 AUD</strong></td>
							      </tr>
							    </tbody>
							</table>

						</div>
					</div>

					<div class="paypalLoginInfo">
						<img src="images/paypalLogin.jpg" height="399" width="490" alt="">	
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- mainBody End -->

	<!-- Color Change Start -->
	<div class="colorChange">
		<div class="switch" id="black">Black</div>
		<div class="switch" id="pink">Pink</div> 
	</div>
	<!-- Color Change End -->
</body>
</html>