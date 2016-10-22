<script src="<?= base_url() .'assets/js/easyResponsiveTabs.js' ;?>" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/global.css" />
<script src="<?= base_url(); ?>assets/js/jquery.elevateZoom-3.0.8.min.js"></script>
<style>
	.product-desc > table  td {
		border: 1px solid #fff;
		padding: 10px;
	}
	.product-desc > table{
		width : 100%;
	}
	
	.product-desc > table tr:nth-child(even){
		background-color 	: #ededed;
	}
	.available li {
		display: list-item;
	}
	
	.zoomWrapper{
		width:100%!important;
		height:100%!important;
		position:relative!important;
	}
	
	.zoomWrapper div{
		display:none!important;
	}
	.zoomLens{
		max-height:100%!important;
		max-width:100%!important;
	}
	.product-gallery img{
		display:block;
		position:absolute;
		left:0;
		right:0;
		bottom: 0;
		top: 0;
		margin:auto;
		max-width:100%!important;
		max-height:100%!important;
		vertical-align:middle;
	}
	
	.product-gallery {
		text-align:center;
		position:relative;
		height: 350px;
		line-height: 22;
		width: 100%;
		float:left;
		padding:20px;
	}
	
	.gallary-navigation{
		margin:auto;
		margin-top:20px;
		position:relative;
		display:table;
		
	}
	
	.product-gallery-wrapper{
		float:left;
		position: relative;
		//height: 500px;
		width: 100%;
		border-right:1px solid #e5e5e5;
	}
</style>
	
<div class="container" style="margin-top:10px;">
	<div class="row">				
		<div class="col-md-4">
			<div class="product-gallery-wrapper">
				<div class="product-gallery">
					<img id="img_01" src="<?php echo base_url() .'assets/images/products/mobiles/' . $Properties->images[0]->Url; ?>" />
				</div>
				<div class="clearifix"></div>
				<div id="gallery" class="gallary-navigation">
					<?php
						if(isset($Properties->images) && count($Properties->images) > 0){
							foreach($Properties->images as $image){ ?>
					<a style="width: 70px;text-align: center; height: 70px; float: left; border: 1px solid #000;padding:3px;line-height: 4" href="#" data-image="<?= base_url() . 'assets/images/products/mobiles/' . $image->Url; ?>" data-zoom-image="<?= base_url() . 'assets/images/products/mobiles/' . $image->ZoomImageUrl; ?>">
						<img style="max-width:100%; max-height:100%; vertical-align:middle; height:auto;" src="<?= base_url() . 'assets/images/products/mobiles/' . $image->Url; ?>"/>
					</a>
					<?php	}
						}
					?>
				</div>
			</div>
			<div class="clearifix"></div>
			<script>
				$(function(){
					//initiate the plugin and pass the id of the div containing gallery images
					$("#img_01").elevateZoom({gallery:'gallery', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true}); 

					//pass the images to Fancybox
					$("#gallery").bind("click", function(e) {  
					  var ez =   $('#img_01').data('elevateZoom');	
						$.fancybox(ez.getGalleryList());
					  return false;
					});
					
				});
			</script>	
		</div>
		
		<div class="col-md-8">
			<h2><?= $Properties->ModelName; ?></h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>					
			<div class="price">
				<?php if(isset($Properties->MinPriceWebstore)){ ?>
					<p>Price: <span><?= $Properties->MinPriceWebstore->Price->currency ." ". $Properties->MinPriceWebstore->Price->amount; ?></span></p>
					<span><?= $Properties->MinPriceWebstore->storeName ;?></span>
				<?php } ?>
			</div>
			<div class="available">
				<p>Web Store Prices :</p>
				<ul>
					<?php 
						if(isset($webStoreProductDetails)){
							foreach($webStoreProductDetails as $webStore => $webstoreDetails){ ?>
							<li><?= $webStore. " Price : " . $webstoreDetails->Price->currency . " " . $webstoreDetails->Price->amount; ?> <a  target="_blank" href="<?= $webstoreDetails->productUrl; ?>">Go To Store</a></li>
					<?php }
						} ?>	
				</ul>
			</div>
			<div class="share-desc">
				<div class="share">
					<p>Share Product :</p>
					<ul>
						<li><a href="#"><img src="<?php base_url() .'assets/images/facebook.png'; ?>" alt="" /></a></li>
						<li><a href="#"><img src="<?php base_url() .'assets/images/twitter.png'; ?>" alt="" /></a></li>					    
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="wish-list">
				<ul>
					<li class="wish"><a href="#">Add to Wishlist</a></li>
					<li class="compare"><a href="#">Add to Compare</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearifix"></div>
	<div class="row">	
		<div class="col-md-9">
			<div class="desclaimer-details">
				<div class="panel disclaimer-panel">
					<div class="panel-header"><?= $Properties->ModelName;?> Product Details</div>
					<div class="panel-body">
						<ul>
							<li><?= $Properties->ModelName;?> best price is Rs <?=$Properties->Price;?>;</li>
							<li>Lowest price of <?= $Properties->ModelName;?> was obtained on <?= date("d-m-Y");?></li>
							<li>The above listed sellers provide delivery in several cities including Mumbai, New Dehli, Banglore, Chennai, Pune, Kolkata, Ahemdabad.</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="horizontalTab">
				<ul class="resp-tabs-list">
					<li>Product Details</li>
					<li>Product Reviews</li>
					<div class="clearifix"></div>
				</ul>
				<div class="resp-tabs-container">
					<div class="product-desc">
						<?= $propertiesDetailTable; ?>
					</div>
					<div class="review">
						<h4>Lorem ipsum Review by <a href="#">Finibus Bonorum</a></h4>
						 <ul>
							<li>Price :<a href="#"><img src="web/images/price-rating.png" alt="" /></a></li>
							<li>Value :<a href="#"><img src="web/images/value-rating.png" alt="" /></a></li>
							<li>Quality :<a href="#"><img src="web/images/quality-rating.png" alt="" /></a></li>
						 </ul>
						 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
					  <div class="your-review">
						 <h3>How Do You Rate This Product?</h3>
						  <p>Write Your Own Review?</p>
						  <form>
								<div>
									<span><label>Nickname<span class="red">*</span></label></span>
									<span><input type="text" value=""></span>
								</div>
								<div><span><label>Summary of Your Review<span class="red">*</span></label></span>
									<span><input type="text" value=""></span>
								</div>						
								<div>
									<span><label>Review<span class="red">*</span></label></span>
									<span><textarea> </textarea></span>
								</div>
							   <div>
									<span><input type="submit" value="SUBMIT REVIEW"></span>
							  </div>
							</form>
						 </div>				
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="row">
				<?= $featuredProducts;?>
			</div>
			<div class="row">
				<?= $popularProducts;?>
			</div>
		</div>
	</div>
	<div class="row">
		<?= $similarProducts; ?>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion           
            width: 'auto', //auto or any width like 600px
            fit: true   // 100% fit in a container
        });
    });
</script>