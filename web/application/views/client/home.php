<link href="<?= base_url() . 'assets/css/slider.css' ;?>" rel="stylesheet" type="text/css" media="all"/>
<script type="text/javascript" src="<?= base_url() . 'assets/js/startstop-slider.js'; ?>"></script>
<script type="text/javascript" src="<?= base_url() . 'assets/js/move-top.js'; ?>"></script>
<script type="text/javascript" src="<?= base_url() . 'assets/js/easing.js'; ?>"></script>
<section id="" style="min-height:500px;">
	<div class="container">
		<div class="row">
			<div class="col-md-3" style="padding:0;">
				<?= $singleCaerosel ?>
			</div>
			<div class="col-md-9">
				<?= $slider ?>
			</div>
		</div>
	</div>
	<div class="clearifix"></div>
	<?= $highlights; ?>
</section>
<section>
	<div class="new-product-area pad-bottom">
		<div class="container">
			<div class="row">
				<?= $featuredProducts ?>
			</div>
		</div>
	</div>
</section>
<div style="clear:both"></div>
<!-- PARALLAX-AREA START -->
<div class="bg-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="bg-content">
					<h1><strong>DISCOVER THE</strong> AMAZING <br /> <strong>Electronics</strong></h1>
					<div class="bg-text">
						<p>Electronics for everyone.</p>						
					</div>
					 <a target="_blank" href="<?= base_url() ?>SubcategoryController/index/mobiles">SHOP NOW</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- PARALLAX-AREA END -->
<section>
	<div class="new-product-area pad-bottom">
		<div class="container">
			<div class="row">
				<?= $popularProducts ?>
			</div>
		</div>
	</div>
</section>
<div style="clear:both"></div>
<?= $suscribeSection ?>

<?= $brandCaerosel; ?>
