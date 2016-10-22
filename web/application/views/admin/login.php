<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!---
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Website Admin Panel</title>
<link rel="stylesheet" href="./Website Admin Panel_files/font-awesome.min.css">

<script src="./Website Admin Panel_files/jquery-1.8.3.min.js.download"></script>
<script src="./Website Admin Panel_files/bootstrap.min.js.download"></script>	
<script src="./Website Admin Panel_files/jquery.validationEngine.js.download"></script>	
<script src="./Website Admin Panel_files/jquery.validationEngine-en.js.download"></script>	
<link href="./Website Admin Panel_files/validationEngine.jquery.css" rel="stylesheet">
 <link href="./Website Admin Panel_files/bootstrap.css" rel="stylesheet">      
  <link rel="stylesheet" href="./Website Admin Panel_files/jquery-ui.css"> 
<link rel="stylesheet" href="./Website Admin Panel_files/style.css">
<link rel="stylesheet" href="./Website Admin Panel_files/style_2.css">
<link rel="stylesheet" href="./Website Admin Panel_files/style2.css">
--->

<style>
	.errorMessage{
		color : #d24242;
	}
	.error{
		display:none;
	}
</style>

<body>
<div class="mid_wrapper">
<div class="container">
<div class="row">
<div class="col-md-4"><img class="img img-responsive" src="<?= base_url();?>assets/images/Admin.png" height="150" width="150"></div>
<div class="col-md-4">
<h3>Admin Login Here :</h3>
<form class="formular" name="admin_login" id="admin_login" action="" method="post"> 

<table class="table table-responsive">
	<tbody>
		<tr class="error">
			<td class="errorMessage" colspan="2"> Invalid</td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" id="username" class="form-control"  placeholder="Username [compulsary]"></td>
		</tr>
		<tr>
			<td>Password:</td><td><input type="password" name="password" id="password" class="form-control"  placeholder="Password [compulsary]"></td>
		</tr>
		<tr>
		<td></td><td><input type="button" value="Login" onclick="login();"></td>
		</tr>

	</tbody>
</table>
</form>
</div>
<div class="col-md-4"></div>
</div><!--row-->
</div><!--container-->
</div><!--mid_wrapper--->



<div class="footer">
<div class="container">
<div class="row">
<div class="col-md-6"><div class="footer_text">All Rights Reserved @ <a href="#">eDreamers</a></div></div>
<div class="col-md-6"><div class="footer_text">Powered By : <a href="#">eDreamers Web Solutions</a></div>

</div><!--row-->
</div><!--container--->
</div><!--footer--->

</div></body>
<script>

		function login(){
			var username = $('#username').val();
			var password = $('#password').val();
			if(validate(username) && validate(password)){
				var data = '{"email":"'+username+'","password":"'+password+'"}';
				ajaxMethodToCreate(data);
			}
		}
		
	
	function ajaxMethodToCreate(jsonData){
		console.log(jsonData);
		$.ajax({
			type: "POST",
			url: "<?= base_url(); ?>/AuthorisationController/adminLogin",
			data: {data:jsonData},
			success: function(res){redirectToAdminHome(res);}
		});
	}
		
		function redirectToAdminHome(res){
			if (res == 'fail'){
				pageMessage('Invalid username or password');
			}else if(res == 'success') {
				window.location.replace('<?= base_url(); ?>/AdminController/subcategories');
			}else if(res == 'not admin'){
				pageMessage('Sorry, You cannot have access. Only Admin user can have access to panel');
			} 
		}
		function pageMessage(message){
			$('.errorMessage').text(message);
			$('.error').show();
		}
		function createSession(){
			
		}
		function validate(){
			return true;
		}
		


		
</script>
<script type="text/javascript">( function(){ window.SIG_EXT = {}; } )()</script>
</html>