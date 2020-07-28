<?php
/* @var $this InvoiceHeaderController */
/* @var $invoice InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	//$invoice->id,
);

// $this->menu=array(
// 	array('label'=>'List InvoiceHeader', 'url'=>array('index')),
// 	array('label'=>'Create InvoiceHeader', 'url'=>array('create')),
// 	array('label'=>'Update InvoiceHeader', 'url'=>array('update', 'id'=>$invoice->id)),
// 	array('label'=>'Delete InvoiceHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$invoice->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage InvoiceHeader', 'url'=>array('admin')),
// );
?>

<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>

		<?php foreach ($invoices as $key => $invoice): ?>
			<?php $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id'=>$invoice->id)); ?>
			<table>
			<tr>
				<td>Invoice Number</td>
				<td><?php echo $invoice->invoice_number; ?></td>
				<td>Invoice Date</td>
				<td><?php echo $invoice->invoice_date; ?></td>
			</tr>
			<tr>
				<td>Reference Type</td>
				<td><?php echo $invoice->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?></td>
				<td>Due Date</td>
				<td><?php echo $invoice->due_date; ?></td>
			</tr>
			<tr>
				<td>Reference Number</td>
				<td><?php if ($invoice->reference_type == 1): ?>
					<?php echo $invoice->salesOrder->sale_order_no; ?>
				<?php else :?>
					<?php echo $invoice->registration_transaction_id; ?>
				<?php endif ?></td>
				<td>Branch</td>
				<td><?php echo $invoice->branch->name; ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><label for="" style="background-color:red;color:white"> <?php echo $invoice->status; ?></label></td>
				<td>User_id</td>
				<td><?php echo $invoice->user_id; ?></td>
			</tr>
		</table>
		<?php 
			$productCriteria = new CDbCriteria;
			$productCriteria->addCondition('invoice_id ='.$invoice->id);
			$productCriteria->addCondition('product_id != ""');
			$products = InvoiceDetail::model()->findAll($productCriteria);
		 ?>
		<?php 
			$serviceCriteria = new CDbCriteria;
			$serviceCriteria->addCondition('invoice_id ='.$invoice->id);
			$serviceCriteria->addCondition('service_id != ""');
		$services = InvoiceDetail::model()->findAll($serviceCriteria); ?>
		<?php 
			$QserviceCriteria = new CDbCriteria;
			$QserviceCriteria->addCondition('invoice_id ='.$invoice->id);
			$QserviceCriteria->addCondition('quick_service_id != ""');
		$Qservices = InvoiceDetail::model()->findAll($QserviceCriteria); ?>
		<fieldset>
			<legend>Details</legend>
			<?php if(count($products) > 0) : ?>
				<table>
					<thead>
						<th>Product</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Price</th>
				</thead>
				<tbody>
					<?php foreach ($details as $i => $detail): ?>
						<?php if($detail->product_id != ""): ?>
						<tr>
							<td><?php echo $detail->product->name; ?></td>
							<td><?php echo $detail->quantity; ?></td>
							<td><?php echo $detail->unit_price; ?></td>
							<td><?php echo $detail->total_price; ?></td>
							
						</tr>
						<?php endif; ?>
					<?php endforeach; ?>

				</tbody>
				
			</table>
		<?php endif; ?>
		<?php if(count($services) > 0 ) : ?>
			<table>
				<thead>
			
					<tr>
						<th>Service</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($details as $i => $detail): ?>
						<?php if ($detail->service_id != ""): ?>
							<tr>
								<td><?php echo $detail->service->name; ?></td>
								
								<td><?php echo $detail->total_price; ?></td>
								
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
						<?php foreach ($details as $i => $detail): ?>
							<?php if ($detail->quick_service_id != ""): ?>
								<tr>
									<td><?php echo $detail->quickService->name; ?></td>
									<td><?php echo $detail->unit_price; ?></td>
									<td><?php echo $detail->total_price; ?></td>
									
								</tr>
							<?php endif ?>
							
						
						<?php endforeach; ?>

					</tbody>
					
				</table>
			<?php endif ?>
		<style type="text/css">
			.totalTable{
				width:30% !important;float:right; border:none;background-color: white;
			}
			.totalTable tr td
			{
				border:none;
				background-color: white;
			}
			.title{
				font-weight: bold;
			}
		</style>
		<table class="totalTable">
			<tr>
				<td class="title">Service Price</td>
				<td><?php echo $invoice->service_price ?></td>
			</tr>
			<tr>
				<td class="title">Product Price</td>
				<td><?php echo $invoice->product_price ?></td>
			</tr>
			<tr>
				<td class="title">Quick Service Price</td>
				<td><?php echo $invoice->quick_service_price ?></td>
			</tr>
			<tr>
				<td class="title">Sub Total</td>
				<td><?php echo $invoice->subTotal ?></td>
			</tr>
			<?php if ($invoice->ppn == 1): ?>
				<tr>
					<td class="title">PPN (10%) </td>
					<td><?php echo $invoice->ppn_total ?></td>
				</tr>
			<?php endif ?>
			<?php if ($invoice->pph == 1): ?>
				<tr>
					<td class="title">PPH (2%) </td>
					<td><?php echo $invoice->pph_total ?></td>
				</tr>
			<?php endif ?>
			
			<tr>
				<td class="title">Total Price</td>
				<td><?php echo $invoice->total_price ?></td>
			</tr>
		</table>
	
		</fieldset>
		<?php endforeach ?>
	</div>
</div>
