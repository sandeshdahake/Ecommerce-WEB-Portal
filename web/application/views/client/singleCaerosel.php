<div class="single-carosel">
<div class="content_top">
	<div class="section-title">
		<h3>Offers</h3>
		<div class="top-navigation">
			<a class="prev"> < </a>
			<a class="next"> > </a>
		</div>
	</div>
</div>
<div class="clearifix"></div>
<div id="owl-demo1" class="owl-carousel">
	<div class="col-md-12">
		<div class="item">
			<img src="<?= base_url() ?>/assets/images/single-caerosel/5.jpg" />
			<div class="item-view"><a target="_blank" href="<?= base_url() ?>ProductController/Details/18">View</a></div>
		</div>
	</div>
	<!--<div class="col-md-12">
		<div class="item">
			<img src="<?= base_url() ?>/assets/images/single-caerosel/6.jpg" />
			<div class="item-view"><a target="_blank" href="<?= base_url() ?>ProductController/Details/62">View</a></div>
		</div>
	</div>
	-->
	<div class="col-md-12">
		<div class="item">
			<img src="<?= base_url() ?>/assets/images/single-caerosel/7.jpg" />
			<div class="item-view"><a target="_blank" href="<?= base_url() ?>ProductController/Details/189">View</a></div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="item">
			<img src="<?= base_url() ?>/assets/images/single-caerosel/8.jpg" />
			<div class="item-view"><a target="_blank" href="<?= base_url() ?>ProductController/Details/78">View</a></div>
		</div>
	</div>
</div>	
</div>
<script>
	$(document).ready(function(){
		var owl1 = $("#owl-demo1");
		owl1.owlCarousel({
			items : 1, //10 items above 1000px browser width
			itemsDesktop : [1000,1], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
			itemsTablet: [600,2], //2 items between 600 and 0;
			itemsMobile : [400,1] // 1
		});
		
		$(".top-navigation").find('.next').click(function(){
			owl1.trigger('owl.next');
		})
		$(".top-navigation").find('.prev').click(function(){
			owl1.trigger('owl.prev');
		});
	});
</script>

<style>
.item img{
	margin:auto;
	display:block;
}
</style>