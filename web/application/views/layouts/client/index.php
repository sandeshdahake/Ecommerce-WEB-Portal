<!DOCTYPE html>
<html>
	<head>	
		<title>Compare Dunia</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?= base_url(); ?>assets/styles/bootstrap_min.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="<?= base_url(); ?>assets/styles/font-awesome.min.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/meanmenu.min.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/owl.carousel.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/smoothslides.theme.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/responsive.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/loginTemplate.css" rel="stylesheet" />
		<link href="<?= base_url(); ?>assets/styles/meanmenu.min.css" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Lato:400,900,700,300" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="<?= base_url() .'assets/js/jquery.js' ?>"></script>
	</head>
	<body>
	<div id="loginTemplate" class="login-out-wrapper">
		<div class="main" >
			<span onclick="document.getElementById('loginTemplate').style.display= 'none'" class="compare-product-remove-btn">x</span>
			<!--login-profile-->
			
			<!--login-profile-->
			<!--signin-form-->
			<div id="loginWrapper" class="login-template" >
				<div class="signin-form profile">
					<h3>Login</h3>
					<div class="login-form">
						<form id="LoginForm" name="LoginForm" method="post">
							<input type="text" name="email" placeholder="E-mail" required="">
							<input type="password" name="password" placeholder="Password" required="">
							<div class="tp">
								<input type="submit" value="LOGIN NOW">
							</div>
						</form>
					</div>
					<div class="header-social wthree">
						<a href="<?= base_url(); ?>AuthorisationController/hALogin/Facebook" class="face">Facebook</a>
						<a href="<?= base_url(); ?>AuthorisationController/hALogin/Google" class="goog">Google+</a>
						<div class="clear"></div>
					</div>
					<p><a href="javascript:void(0)" onclick="showSignUpForm()"> Sign Up</a></p>
				</div>
			</div>
			<div id="signUpWrapper" class="" style="display:none;">
				<div class="signin-form profile">
					<h3>Register</h3>
					<div class="login-form">
						<form name="signUpForm" id="signUpForm" action="#" method="post">
							<div class="signUpError"></div>
							<input type="text" name="email" placeholder="E-mail" required="true">
							<input type="text" name="firstName" placeholder="First Name" required="true">
							<input type="text" name="lastName" placeholder="Last Name" required="true">
							<input type="password" name="password" placeholder="Password" required="true">
							<input type="password" name="confirmPassword" placeholder="Confirm Password" required="true">
							<label><input type="checkbox"  name="termsConditions" required/> By clicking register, I agree to your terms</label>
							<input type="submit" value="REGISTER">
						</form>
					</div>
					<p></p>
					<p><a href="javascript:void(0)" onclick="showLogInForm()">Log In</a></p>
				</div>
				
			</div>
			<div class="clear"></div>
			<!--//signin-form-->	
		</div>
	</div>
		<?php if($header) echo $header ;?>
		<?php //  if($left) echo $left ;?>
		<?php if($middle) echo $middle ;?>
		<?php if($footer) echo $footer ;?>
		
		<script>
			function showSignUpForm(){
				$("#loginWrapper").hide();
				$("#signUpWrapper").show();
			}
			
			function showLogInForm(){
				$("#loginWrapper").show();
				$("#signUpWrapper").hide();
			}
			
			
			$("#LoginForm").submit(function(e){
				e.preventDefault();
				var data = {};
				$.each(this, function(index, element){
					if(element.type=="text" || element.type=="password"){
						data[element.name] = element.value;
					}
				});
				
				$.ajax({
					method:"POST",
					url: "<?= base_url() ?>AuthorisationController/login",
					data:{data:data},
					success:function(data){
						document.location.reload();
					},
					error:function(error, msg){
						console.log(error);
					}
				});
			});
			
			$("#signUpForm").submit(function(e){
				e.preventDefault();
				$(".signUpError").text('');
				var data = {};
				$.each(this, function(index, element){
					if(element.type=="text" || element.type=="password" || element.type=="checkbox"){
						data[element.name] = element.value;
					}
				});
				
				if(data.confirmPassword != data.password){
					$(".signUpError").text('Password not matched');
					return;
				}
				if(!validateEmail(data.email)){
					$(".signUpError").text('Invalid Email Address');
					return;
				}
				
				$.ajax({
					method:"POST",
					url: "<?= base_url() ?>AuthorisationController/signUp",
					data:{data:data},
					success:function(data){
						if(data == 'User already Exists'){
							$(".signUpError").text(data);
						}
						else {
							document.location.reload();
						}
					},
					error:function(error, msg){
						console.log(error);
					}
				});
				
			});
			
			function logout(){
				$.ajax({
					method:"GET",
					url: "<?= base_url(); ?>AuthorisationController/logout",
					success:function(){
						document.location.reload();
					}
				});
			}
			
			/** -- resize -- **/
			$(window).resize(function() {
				console.log($(window).width());
				setLoginTemplateMargin()
			});
			
			function setLoginTemplateMargin(){
				var marginLeft = (($(window).width()/2)-160) + 'px';
				console.log('margin-left : ' + marginLeft);
				$(".main").css('left', marginLeft );
			}
			
			function validateEmail(email) {
				var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			}
			setLoginTemplateMargin();
		</script>
		
		<script src="<?= base_url();?>assets/js/underscore-min.js"></script>
		<script src="<?= base_url();?>assets/js/bootstrap_min.js"></script>
		<script src="<?= base_url();?>assets/js/owl.carousel.min.js"></script>
		<script src="<?= base_url();?>assets/js/jquery.meanmenu.min.js"></script>
		<script>
		$(document).ready(function(){
			$('nav#dropdown').meanmenu();
		});
		</script>
	</body>
</html>