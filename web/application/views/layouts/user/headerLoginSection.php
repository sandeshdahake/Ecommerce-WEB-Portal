<div class="total-cart">
	<?php if(isset($user)){ ?>
	<div class="cart-toggler">
		<a href="#">
			<span class="cart-title"><?= $user->FirstName . ' ' . $user->LastName; ?></span>
		</a>
	</div>
	<ul>
		<li>
			<div class="cart-img">
				<a href="#">My Profile</a>
			</div>
		</li>
		<li>
			<div class="cart-img">
				<a href="javascript:logout();">Logout</a>
			</div>
		</li>
	</ul>
	<?php } else{ ?>
	<div class="cart-toggler">
		<a href="#">
			<span class="cart-title" onclick="document.getElementById('loginTemplate').style.display = 'block'">Log In</span>
		</a>
	</div>
	<?php } ?>
</div>