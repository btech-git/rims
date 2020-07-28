<?php
/* @var $this MovementOutHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Movement Out Headers',
);

$this->menu=array(
	array('label'=>'Create MovementOutHeader', 'url'=>array('create')),
	array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
);
?>

<h1>Movement Out List</h1>

<?php //$this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); ?>

<table>
	<thead>
		<th>Request Type</th>
		<th>Request Number</th>
		<th>Request Date</th>
		<th>Items</th>
		<th>Movements</th>
	</thead>
	<tbody>
		<tr>
			<td rowspan="<?php echo count($deliveryOrders)+1; ?>">Delivery Order</td>
		</tr>
		<?php foreach ($deliveryOrders as $key => $deliveryOrder): ?>
			
			<tr>
				
				<td><?php echo $deliveryOrder->delivery_order_no; ?></td>
				<td><?php echo $deliveryOrder->delivery_date; ?></td>
				<td>
					<table>
						<thead>
							<th>Product</th>
							<th>Quantity Delivery</th>
							<th>Quantity Movement</th>
						</thead>
						<tbody>
							<?php foreach ($deliveryOrder->transactionDeliveryOrderDetails as $key => $deliveryDetail): ?>
								<tr>
									<td><?php echo $deliveryDetail->product->name; ?></td>
									<td><?php echo $deliveryDetail->quantity_delivery; ?></td>
									<td><?php echo $deliveryDetail->quantity_movement; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					
				</td>
				<td>
					<?php if($deliveryOrder->movementOutHeaders != ""){
						$first = true;
							$recDo = "";
							
							
							foreach($deliveryOrder->movementOutHeaders as $moDelivery)
							{
								
								if($first === true)
								{
									$first = false;
								}
								else
								{
									$recDo .= ', ';
								}
								$recDo .= $moDelivery->movement_out_no;

							}
							echo $recDo;
						} 
						else{
							echo " NO MOVEMENT";
						}
						?>

				</td>
			</tr>
		<?php endforeach ?>
		<tr>
			<td rowspan="<?php echo count($returnOrders)+1; ?>">Return Order</td>
		</tr>
		<?php foreach ($returnOrders as $key => $returnOrder): ?>
			<tr>
				
				<td><?php echo $returnOrder->return_order_no; ?></td>
				<td><?php echo $returnOrder->return_order_date; ?></td>
				<td>
					<table>
						<thead>
							<th>Product</th>
							<th>Quantity Reject</th>
							<th>Quantity Movement</th>
						</thead>
						<tbody>
							<?php foreach ($returnOrder->transactionReturnOrderDetails as $key => $returnDetail): ?>
								<tr>
									<td><?php echo $returnDetail->product->name; ?></td>
									<td><?php echo $returnDetail->qty_reject; ?></td>
									<td><?php echo $returnDetail->quantity_movement; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					
				</td>
				<td>
					<?php if($returnOrder->movementOutHeaders != ""){
						$first = true;
							$recRo = "";
							
							
							foreach($returnOrder->movementOutHeaders as $moDelivery)
							{
								
								if($first === true)
								{
									$first = false;
								}
								else
								{
									$recRo .= ', ';
								}
								$recRo .= $moDelivery->movement_out_no;

							}
							echo $recRo;
						} 
						else{
							echo " NO MOVEMENT";
						}
						?>

				</td>
			</tr>
		<?php endforeach ?>
		<tr >
			<td rowspan="<?php echo count($retailSales)+1; ?>" >Retail Sales</td>
		</tr>
		<?php foreach ($retailSales as $key => $retailSale): ?>
			<?php if(count($retailSale->registrationProducts)!= 0): ?>
			<tr>
				<td><?php echo $retailSale->transaction_number; ?></td>
				<td><?php echo $retailSale->transaction_date; ?></td>
				<td>
					<table>
						<thead>
							<th>Product</th>
							<th>Quantity</th>
							<th>Quantity Movement</th>
						</thead>
						<tbody>
							<?php foreach ($retailSale->registrationProducts as $key => $retailDetail): ?>
								<tr>
									<td><?php echo $retailDetail->product->name; ?></td>
									<td><?php echo $retailDetail->quantity; ?></td>
									<td><?php echo $retailDetail->quantity_movement; ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					
				</td>
				<td>
					<?php if($retailSale->movementOutHeaders != ""){
						$first = true;
							$recRs = "";
							
							
							foreach($retailSale->movementOutHeaders as $moDelivery)
							{
								
								if($first === true)
								{
									$first = false;
								}
								else
								{
									$recRs .= ', ';
								}
								$recRs .= $moDelivery->movement_out_no;

							}
							echo $recRs;
						} 
						else{
							echo " NO MOVEMENT";
						}
						?>

				</td>
			</tr>
		<?php endif ?>
		<?php endforeach ?>
	</tbody>
</table>