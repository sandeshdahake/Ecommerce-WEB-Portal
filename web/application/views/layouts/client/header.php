<header>
	<div class="header-top">
		<div class="container">
			<div class="row">
				<div class="col-md-6" style="color:white;">
					<i class="fa fa-envelope"> Email: </i>contact@comparedunia.net
				</div>
				<div class="col-md-6">
					
				</div>
			</div>
		</div>
	</div>
	<div class="header-middle">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="logo">
						<!-- <a href="<?= base_url(); ?>"><img src="img/logo/logo.png" alt="" /></a> -->
						<h1>Compare Dunia</h1>
					</div>
				</div>
				<div class="col-lg-6 col-md-5 col-sm-4 col-xs-12">
					<form  id="search" class="header-search">
						<input id="searchinput" type="text" onkeyup="getSuggestions(this.value)"  placeholder="search product..." />
						<button><i class="fa fa-search"></i></button>
						<div id="suggestions" tabindex="12" class="suggestions"></div>
					</form>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					<?= $userSectionTemplate; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="header-bottom main-menu-area main-menu-area-2 hidden-xs">
		<div class="container">
			<div class="main-menu">
				<nav>
					<ul>
						<li><a href="<?= base_url(); ?>">home</a></li>
						<li><a href="<?= base_url()?>About_Us">About</a></li>									
						<li><a href="<?= base_url(). 'SubcategoryController/index/mobiles' ?>">Mobile</a></li>
						<li><a href="<?= base_url(). 'SubcategoryController/index/laptops' ?>">Laptops</a></li>
						<li><a href="<?= base_url(). 'SubcategoryController/index/tablets' ?>">Tablets</a></li>
						<li><a href="contact.html">contact</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="clearifix"></div>
	</div>
	<!-- mobile-menu-area start -->
	<div class="header-bottom mobile-menu-area visible-xs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="mobile-menu">
						<nav id="dropdown">
							<ul>
								<li><a href="<?= base_url(); ?>">home</a></li>
								<li><a href="<?= base_url()?>About_Us">About</a></li>									
								<li><a href="<?= base_url(). 'SubcategoryController/index/mobiles' ?>">Mobile</a></li>
								<li><a href="<?= base_url(). 'SubcategoryController/index/laptops' ?>">Laptops</a></li>
								<li><a href="<?= base_url(). 'SubcategoryController/index/tablets' ?>">Tablets</a></li>
								<li><a href="contact.html">contact</a></li>
							</ul>
						</nav>
					</div>					
				</div>
			</div>
		</div>
	</div>
			<!-- mobile-menu-area end -->
	<script>
		
		// request products
		function getSuggestions($key){
			if($key.length > 3) {
				$.ajax({
					type:'GET',
					url:'<?= base_url();?>/ProductController/productSuggestions/' + $key,
					dataType:"json",
					success:function(data){
						console.log(data);
						var template = _.template($("#autosuggestions").html());
						$("#suggestions").html(template({productsList:data}));
					}
				});
			}
		}
		
		
		$('#search').on('focusout',function(e){ // When losing focus
			 setTimeout(function() {
				$("#suggestions").hide();
			}, 1000);
		});
		
		$('#searchinput').on('focus',function(){ // When losing focus
			$("#suggestions").show();
		});
	
	</script>
	<script id="autosuggestions" type="text/template">
		<ul class="">
			<% _.each(productsList, function(product, index){%>
			<li class=""><a class="" href="<?= base_url();?>ProductController/Details/<%= product.Id%>"><%= product.Name %></a></li>
			<% });%>
		</ul>
	</script>
</header>