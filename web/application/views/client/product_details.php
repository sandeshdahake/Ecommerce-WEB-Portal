<script src="<?= base_url() .'assets/js/easyResponsiveTabs.js' ;?>" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/css/easy-responsive-tabs.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/global.css" />
<script src="<?= base_url(); ?>assets/js/jquery.elevateZoom-3.0.8.min.js"></script>
<div class="container" style="margin-top:10px;">
	<div class="row">				
		<div class="col-md-4">
			<div class="product-gallery-wrapper">
				<?php
				if(isset($Properties->images) && count($Properties->images) > 0){
				?>
					<div class="product-gallery">
						<img id="img_01" src="<?= base_url() .'assets/images/products/mobiles/' . $Properties->images[0]->Url; ?>" />
					</div>
					<div class="clearifix"></div>
					<div id="gallery" class="gallary-navigation">
						<?php
							foreach($Properties->images as $image){ ?>
						<a style="width: 70px;text-align: center; height: 70px; float: left; border: 1px solid #000;padding:3px;line-height: 4" href="#" data-image="<?= base_url() . 'assets/images/products/mobiles/' . $image->Url; ?>" data-zoom-image="<?= base_url() . 'assets/images/products/mobiles/' . $image->ZoomImageUrl; ?>">
							<img style="max-width:100%; max-height:100%; vertical-align:middle; height:auto;" src="<?= base_url() . 'assets/images/products/mobiles/' . $image->Url; ?>"/>
						</a>
						<?php	
							}
						?>
					</div>
				<?php 
				}
				else if($Properties->Image!= ""){
				?>
					<div class="product-gallery">
						<img id="img_01" src="<?php echo base_url() .'assets/images/products/'.$Properties->Image; ?>" />
					</div>
				<?php 
				} 
				else{
				?>
					<div class="product-gallery">
						<img id="img_01" src="<?php echo base_url() .'assets/images/products/no-image-available.jpg' ?>" />
					</div>
				<div class="clearifix"></div>
				<?php
				}
				?>
				
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
			<h2 class="detail-poduct-name"><?= $Properties->Name; ?></h2>
			
			<div class="price">
				<?php if(isset($Properties->MinPriceWebstore)){ ?>
					<div>
						<div class="pro-price">
							<span class="normal">Rs. <?= $Properties->Price; ?></span>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="store-details" style="border:0">
						<div class="store-name"><?= $Properties->MinPriceWebstore->label ;?></div>
						<ul>
							<?php if( $Properties->MinPriceWebstore->CodAvailable) {?><li><?= $Properties->MinPriceWebstore->CodAvailable ;?></li> <?php } ?>
							<?php if( $Properties->MinPriceWebstore->DeliveryInfo != "") {?><li><?= $Properties->MinPriceWebstore->DeliveryInfo ;?></li> <?php } ?>
							<?php if( $Properties->MinPriceWebstore->Sheeping != "") {?><li><?= $Properties->MinPriceWebstore->Sheeping ;?></li> <?php } ?>
						</ul>
						<div class="pro-button-top"><a target="_blank" href="<?= $Properties->MinPriceWebstore->productUrl; ?>">Go to Store</a></div>
					</div>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
			<div class="available">
				
			</div>
			
			<div class="wish-list">
				<!--<ul>
					<li class="wish"><a href="#">Add to Wishlist</a></li>
					<li class="compare"><a href="#">Add to Compare</a></li>
				</ul>
				-->
			</div>
		</div>
	</div>
	<div class="clearifix"></div>
	<div class="row">	
		<div class="col-md-9">
			<div class="web-stores-details">
				<div class="panel detail-page-panel">
					<div class="panel-header"><?= $Properties->Name;?> Prices</div>
					<div class="panel-body">
					<?php 
						if(isset($webStoreProductDetails) && count($webStoreProductDetails)>0){
							foreach($webStoreProductDetails as  $webstoreDetails){ ?>
							<div class="store-details">
								<div class="row">
									<div class="col-md-3">
										<div class="store-image"><img src="<?= $webstoreDetails->storeLogo;?>"/></div>
									</div>
									<div class="col-md-3">
										<ul>
											<?php if( $webstoreDetails->CodAvailable) {?><li><?= $webstoreDetails->CodAvailable ;?></li> <?php } ?>
											<?php if( $webstoreDetails->DeliveryInfo != "") {?><li><?= $webstoreDetails->DeliveryInfo ;?></li> <?php } ?>
											<?php if( $webstoreDetails->Sheeping != "") {?><li><?= $webstoreDetails->Sheeping ;?></li> <?php } ?>
										</ul>
									</div>
									<div class="col-md-3">
										<div class="pro-price">
											<span class="normal">Rs. <?= moneyFormatIndia($webstoreDetails->Price->amount); ?></span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="pro-button-top"><a target="_blank" href="<?=$webstoreDetails->productUrl; ?>">Go to Store</a></div>
									</div>
								</div>
							</div>
							<div class="clearifix"></div>
					<?php }
						} ?>	
					</div>
				</div>
			</div>
			<div class="desclaimer-details">
				<div class="panel detail-page-panel">
					<div class="panel-header"><?= $Properties->Name;?> Product Details</div>
					<div class="panel-body">
						<ul>
							<li><?= $Properties->Name;?> best price is Rs <?=$Properties->Price;?>;</li>
							<li>Lowest price of <?= $Properties->Name;?> was obtained on <?= date("d-m-Y");?></li>
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
					<div class="product-desc">
						<div class="row">
							<h4 style="margin-left:10px;"><?= $Properties->Name; ?></h4>
							<div class="reviews">
								<?php
									if(count($webStoreProductDetails) > 0){
										foreach($webStoreProductDetails as $webStore){
								?>
								<div class="col-md-3">
									<div class="review-tile">
										<div class="img img-responsive review-webstore-img">
											<img src="<?= $webStore->storeLogo; ?>" />
										</div>
										<div class="read-all-review">
											<a href="<?= $webStore->ReviewPageUrl ?>">Read All Reviews</a>
										</div>
									</div>
								</div>
								<?php
										}
									}
								?>
							</div>
						</div>
						<div class="row">
							<?= $reviewTemplate; ?>
							
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
<?php
	/*function moneyFormatIndia($num){
		$explrestunits = "" ;
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0)
				{
					$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
				}else{
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash = $explrestunits.$lastthree;
		} else {
			$thecash = $num;
		}
		return $thecash; // writes the final format where $currency is the currency symbol.
	}
*/
?>