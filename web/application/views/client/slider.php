<link rel="stylesheet" href="<?= base_url() . 'assets/styles/smoothslides.theme.css'; ?>" type="text/css"  />
<div class="smoothslides" id="myslideshow1">
	<?php if(count($banners) > 0){ 
		foreach($banners as $banner){ ?>
			<a href="<?= base_url() . $banner->ExtraParam; ?>" target="_blank"><img src="<?= base_url() . 'assets/images/banners/'. $banner->Value;?>" /></a>
	<?php } 
	} ?>
</div>
<script src="<?= base_url(); ?>assets/js/smoothslides-2.2.1.min.js"></script>
<script>
	$(window).load( function() {
		$('#myslideshow1').smoothSlides({
			pagination:true,
			effectDuration: 3000,
			effect: 'zoomIn,crossFade',
			transitionDuration:1000
		});
	});
</script> 
