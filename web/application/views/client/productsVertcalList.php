<div class="product-vertcal-list">
	<div class="panel">
		<div class="panel-header"><?= $listName; ?></div>
		<div class="panel-body">
			<ul class="filters">
			<?php 
				if(isset($productsList) && count($productsList) > 0){
					foreach($productsList as $product){	
			?>
				<li><a href="<?= base_url(). 'ProductController/Details/' .$product->Id;?>"><?= $product->Name; ?></a></li>
			<?php 
					}
				}
			?>
			</ul>
		</div>
	</div>
</div>
