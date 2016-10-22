<div>
	<table class="mobile-detail-table">
		<?php
		foreach($groupsList as $group){ 
			echo "<tr class='group-name'><td colspan='2'>".$group->grouplabel ."</td</tr>";
			foreach($group->properties as $property){ ?>
			<tr class="property">
				<th><?= $property->label; ?></th>
				<?php if(property_exists($productDetails, $property->name)){ ?>
					<td><?= $productDetails->{$property->name}; ?></td>
				<?php } else{ ?>
					<td></td>
				<?php } ?>
			</tr>
		<?php	
			}
		}
		?>
	</table>
</div>