<div class="content_top">
	<div class="section-title">
		<h3><?= $ListName; ?></h3>
	</div>
</div>
<?php
	if(count($Products)>0){
	$caeroselId = str_replace(' ', '_', $ListName);
?>
<div id="<?= $caeroselId;?>" class="owl-carousel">
	<?php 
	
	foreach($Products as $product){  ?>
		<div class="col-lg-12">
		<div class="product-tile">
			<?php If($product->IsBestSeller)  echo '<span class="bestseller">Best seller</span>'; ?>
			<a class="product-img-holder" href="<?= base_url().'ProductController/Details/'.$product->Id;?>">
				<img src="<?= base_url() . 'assets/images/products/' . $product->Image;?>" alt="" />
			</a>
			<div class="product-info">
				<h3><a href="<?= base_url(); ?>ProductController/Details/<?= $product->Id;?>"><?= $product->Name;?></a></h3>
				<div class="pro-price">
					<span class="normal">Rs. <?= $product->Price;?></span>
				</div>
				<div class="star-ratings-sprite"><span title="<?= round($product->Rating, 1);?> Rating out of 5" style="width:<?= $product->Rating*20; ?>%" class="rating"></span></div>
				<div class="clear"></div>
			</div>
			<!--- hover 
			<div class="product-hover">
			<div class="product-links">
				<a href="#"><i class="fa fa-search"></i></a>
				<a href="#"><i class="fa fa-heart"></i></a>
				<a href="#"><i class="fa fa-exchange"></i></a>  
			</div>
			<div class="p-bottom-cart">
				 <a href="cart.html" class="hover-cart">ADD TO <span>Compare</span></a>
			</div>
			
			</div>
			-->
		</div>
		</div>
	<?php } ?>
</div>
<div class="customNavigation <?= $caeroselId;?>Navigation">
	<a class="btn prev"><</a>
	<a class="btn next">></a>
</div>
<?php }
	else{
		echo "<p>No $ListName found.</p>";
	}
?>
<script>
	$(document).ready(function() {
		var owl = $("#<?= $caeroselId;?>");
		owl.owlCarousel({
			items : 4, //10 items above 1000px browser width
			itemsDesktop : [1000,4], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
			itemsTablet: [600,2], //2 items between 600 and 0;
			itemsMobile : [400,1] // 1
		});

		// Custom Navigation Events
		$(".<?= $caeroselId;?>Navigation").find(".next").click(function(){
			owl.trigger('owl.next');
		})
		
		$(".<?= $caeroselId;?>Navigation").find(".prev").click(function(){
			owl.trigger('owl.prev');
		});
	});
</script>
