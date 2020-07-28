<?php if (count($damages) > 0): ?>
	<table>
		<thead>
			<tr>
				<th>Service</th>
				<th>Damage</th>
				<th>Description</th>
				<th>Hour</th>
<!--				<th>Products</th>-->
				<th>Waiting Time</th>
			
			</tr>
		</thead>
		<tbody>
			<?php foreach ($damages as $i => $damage): ?>
				<tr>
					<td><?php echo $damage->service_id != "" ? $damage->service->name : ""; ?></td>
					<td><?php echo $damage->damage_type; ?></td>
					<td><?php echo $damage->description; ?></td>
					
					<td><?php echo $damage->hour; ?></td>
<!--					<td><?php //echo $damage->product->name; ?>
						<?php /*$first = true;
							$rec = "";
							
							$materials = ServiceMaterial::model()->findAllByAttributes(array('service_id'=>$damage->service_id));
							foreach($materials as $material)
							{
								$product = Product::model()->findByPk($material->product_id);
								if($first === true)
								{
									$first = false;
								}
								else
								{
									$rec .= '; ';
								}
								$rec .= $product->name;
								echo $rec;
							}*/ ?>
					</td>-->
					<td><?php echo $damage->waiting_time; ?></td>
					
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
