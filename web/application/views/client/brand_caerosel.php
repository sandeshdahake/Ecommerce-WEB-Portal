<!-- brand-area start -->
<div class="brand-area">
	<div class="container">
		<div class="row">
			<div class="section-title">
				<h3>Top Brands</h3>
			</div>						
		</div>				
		<div class="row">
			<div id="owl-brand" class="brand-carousel">
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Apple"><img src="<?= base_url()?>assets/images/brand/apple.png" alt="" /></a>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Samsung"><img src="<?= base_url()?>assets/images/brand/samsung.png" alt="" /></a>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Motorola"><img src="<?= base_url()?>assets/images/brand/moto.png" alt="" /></a>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Sony"><img src="<?= base_url()?>assets/images/brand/sony.png" alt="" /></a>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Asus"><img src="<?= base_url()?>assets/images/brand/asus.png" alt="" /></a>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=Microsoft"><img src="<?= base_url()?>assets/images/brand/microsoft.png" alt="" /></a>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="single-brand">
						<a href="<?= base_url()?>SubcategoryControllerNew/index/mobiles#/sortby=popularity&Brand=HTC"><img src="<?= base_url()?>assets/images/brand/htc.png" alt="" /></a>
					</div>
				</div>
				
			</div>
			<div class="customNavigation brandCaeroselNavigation">
				<a class="btn prev"><</a>
				<a class="btn next">></a>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var brandOwl = $("#owl-brand");
		brandOwl.owlCarousel({
			items : 6, //10 items above 1000px browser width
			 itemsDesktop : [1199,5],
			  itemsDesktopSmall : [980,4],
			  itemsTablet: [768,2],
			  itemsMobile : [479,1],
			
		});
		
		// Custom Navigation Events
		$(".brandCaeroselNavigation").find(".next").click(function(){
			brandOwl.trigger('owl.next');
		})
		
		$(".brandCaeroselNavigation").find(".prev").click(function(){
			brandOwl.trigger('owl.prev');
		});
	});
</script>
<!-- brand-area end -->