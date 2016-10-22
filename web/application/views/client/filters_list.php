<form id="product_filters_form" name="product_filters_form" method="get">
	<?php
	foreach($filtersList as $filter){	
	?>
	<div class="panel">
		<div class="panel-header"><?= $filter->Name; ?></div>
		<div class="panel-body">
			<ul class="filters">
				<?php 
					if(property_exists($filter, 'details')){
						foreach($filter->details as $filterValue){
				?>
						<li><label><input type="checkbox" name="<?= $filter->Name; ?>" value="<?= $filterValue->Value; ?>" /><?= $filterValue->Value;  ?></li>
				<?php 
						}
					}
				?>
			</ul>
		</div>
	</div>
	<?php
	}
	?>
</form>