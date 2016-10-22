<style>
	.images_1_of_4 img {
		/* max-width: 100%; */
		height: 160px;
	}
</style>
<div class="content">
	<div class="content_top">
		<div class="heading">
			<h3>Mobiles</h3>
		</div>
		<div class="clear"></div>
	</div>
	<div class="section group">
		<?php 
		if(count($productsList) > 0){
			foreach($productsList as $product){ ?>
		<div class="grid_1_of_4 images_1_of_4">
			<a  href="<?= base_url(); ?>Product/Details/<?= $product->ProductId; ?>"><img src="<?= base_url() . 'assets/images/products/' .$product->Image; ?>" alt="" /></a>
			<h2><?= $product->Name; ?></h2>
			<div class="price-details">
			   <div class="price-number">
					<p><span class="rupees">Rs: <?= $product->Price; ?></span></p>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<?php 
			} 
		}
		?>
	</div>
</div>
