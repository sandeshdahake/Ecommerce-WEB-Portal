<div class="container">
	<?php if(isset($products) && count($products)>0){ ?>
		<div class="row">
			<table class="compare-table">
			<tr>
				<th></th>
				<?php	foreach($products as $product){ ?>
				<td><div class="compare-image"> <img src="<?= base_url().'assets/images/products/'. $product->Image; ?>" /></div></td>
				<?php	}  ?>
			</tr>
			<th>Product Link</th>
				<?php	foreach($products as $product){ ?>
						<td>
							<div class="pro-button-top"><a target="_blank" href="<?= base_url().'ProductController/Details/'. $product->Id; ?>">Go to Product</a></div>
				<?php	}  ?>
			</tr>
				<th>Best Price</th>
				<?php	foreach($products as $product){ ?>
				<td><div class="pro-price">
						<span class="normal">Rs. <?php echo moneyFormatIndia((integer)$product->Price); ?></span>
					</div>
				</td>
				<?php	}  ?>
			</tr>
			<?php
			foreach($template as $group){ 
				foreach($group->properties as $property){ ?>
				<tr>
					<th><?= $property->label; ?></th>
					<?php for($i=0; $i < count($products); $i++){ ?>
					<td><?php if($products[$i]->{$property->name}){ echo $products[$i]->{$property->name}; } else echo "-" ; ?></td>
					<?php } ?>
				</tr>
			<?php	
				}
			}
			?>
			</table>
		</div>
	<?php } else{ ?>
	<h2>Please Select Products to compare.</h2>
	<?php } ?>
</div>
<?php
	function moneyFormatIndia($num){
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
?>