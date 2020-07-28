	<?php 
		$productCriteria = new CDbCriteria;
		$productCriteria->addCondition('invoice_id ='.$invoice->header->id);
		$productCriteria->addCondition('product_id != ""');
		$products = InvoiceDetail::model()->findAll($productCriteria);
	 ?>
	<?php 
		$serviceCriteria = new CDbCriteria;
		$serviceCriteria->addCondition('invoice_id ='.$invoice->header->id);
		$serviceCriteria->addCondition('service_id != ""');
	$services = InvoiceDetail::model()->findAll($serviceCriteria); ?>
	<?php 
		$QserviceCriteria = new CDbCriteria;
		$QserviceCriteria->addCondition('invoice_id ='.$invoice->header->id);
		$QserviceCriteria->addCondition('quick_service_id != ""');
	$Qservices = InvoiceDetail::model()->findAll($QserviceCriteria); ?>
	<?php if(count($invoice->details) != 0) {	?>
	<?php if (count($products) > 0): ?>
		<table>
			<thead>
	
				<th>Product</th>
				<th>Quantity</th>
				<th>Unit Price</th>
			
				<th>Price</th>
			
		</thead>
		<tbody>
			<?php foreach ($invoice->details as $i => $detail): ?>
				<?php if($detail->product_id != ""): ?>
				<tr>
					<td><?php echo $detail->product_id; ?></td>
					<td><?php echo $detail->quantity; ?></td>
					<td><span class="numbers"><?php echo $detail->unit_price; ?></span></td>
					<td><span class="numbers"><?php echo $detail->total_price; ?></span></td>
					
				</tr>
				<?php endif; ?>
			<?php endforeach; ?>

		</tbody>
		
	</table>
	<?php endif ?>
	
	<?php $type = $invoice->header->reference_type == "" ? $_POST['InvoiceHeader']['reference_type'] : $invoice->header->reference_type; ?>
	<?php if($type == '2') : ?>
		<?php if(count($services) > 0 ) : ?>
			<table>
				<thead>
			
					<tr>
						<th>Service</th>
						
						<th>Unit Price</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($invoice->details as $i => $detail): ?>
						<?php if ($detail->service_id != ""): ?>
							<tr>
								<td><?php echo $detail->service_id; ?></td>
								<td><span class="numbers"><?php echo $detail->unit_price; ?></span></td>
								<td><span class="numbers"><?php echo $detail->total_price; ?></span></td>
								
							</tr>
						<?php endif ?>
						
					
					<?php endforeach; ?>

				</tbody>
				
			</table>
			<?php endif; ?>
			<?php if (count($Qservices) >0 ): ?>
				<table>
					<thead>
				
						<tr>
							<th>Quick Service</th>
							
							<th>Unit Price</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($invoice->details as $i => $detail): ?>
							<?php if ($detail->quick_service_id != ""): ?>
								<tr>
									<td><?php echo $detail->quick_service_id; ?></td>
									<td><span class="numbers"><?php echo $detail->unit_price; ?></span></td>
									<td><span class="numbers"><?php echo $detail->total_price; ?></span></td>
									
								</tr>
							<?php endif ?>
							
						
						<?php endforeach; ?>

					</tbody>
					
				</table>
			<?php endif ?>
			
		
	<?php endif; ?>
	<?php }?>
	
<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>