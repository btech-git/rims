<?php
/* @var $this TransactionReturnOrderController */
/* @var $model TransactionReturnOrder */

$this->breadcrumbs=array(
	'Transaction Return Orders'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnOrder', 'url'=>array('create')),
	array('label'=>'Update TransactionReturnOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionReturnOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionReturnOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<div class="clearfix page-action">
	<?php $ccontroller = Yii::app()->controller->id; ?>
	<?php $ccaction = Yii::app()->controller->action->id; ?>
	<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Return Order', Yii::app()->baseUrl.'/transaction/transactionReturnOrder/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionReturnOrder.admin"))) ?>
	
	<?php 
		$movements = MovementOutHeader::model()->findAllByAttributes(array('return_order_id'=>$model->id));
	if (count($movements) == 0 && $model->status != 'Rejected'): ?>
		<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/transactionReturnOrder/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionReturnOrder.update"))) ?>
				
			 
	<?php endif ?>
	<?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/transactionReturnOrder/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionReturnOrder.updateApproval"))) ?>

		<h1>View TransactionReturnOrder #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'return_order_no',
				'return_order_date',
				'receive_item_id',
				'recipient_id',
				'recipient_branch_id',
			),
		)); ?>
	</div>
</div>
<div class="detail">
	<hr>
	<h3>Details</h3>
	
		<?php if ($model->request_type =='Purchase Order'): ?>
			<div class="row">
				<div class="small-12 columns">
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">PO no</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo $model->purchaseOrder->purchase_order_no; ?></label>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">Supplier</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo count($model->supplier)== 0?'-':$model->supplier->name; ?></label>
							</div>
						</div>
					</div>
				</div>
			</div>


		<?php elseif($model->request_type =='Internal Delivery Order'): ?>
			<div class="row">
				<div class="small-12 columns">
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">Internal Delivery Order</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo $model->deliveryOrder->delivery_order_no; ?></label>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">Destination Branch</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo count($model->branchDestination)== 0?'-':$model->branchDestination->name; ?></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php elseif ($model->request_type =='Consignment In'): ?>
			<div class="row">
				<div class="small-12 columns">
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">Consignment In no</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo $model->consignmentIn->consignment_in_number; ?></label>
							</div>
						</div>
					</div>
					<div class="field">
						<div class="row collapse">
							<div class="small-4 columns">
								<label for="label">Supplier</label>
							</div>
							<div class="small-8 columns">
								<label for="label"><?php echo count($model->supplier)== 0?'-':$model->supplier->name; ?></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>

		<?php if (count($returnDetails)>0): ?>
			<table>
				<thead>
					<tr>
						<td>Product</td>
                        <td>Code</td>
                        <td>Kategori</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
						<td>QTY Receive</td>
						<td>QTY Return</td>
						<td>Note</td>
						<td>Barcode Product</td>
						<td>Quantity Movement</td>
						<td>Quantity Movement Left</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($returnDetails as $key => $returnDetail): ?>
						<tr>
							<td><?php echo $returnDetail->product->name == ''?'-':$returnDetail->product->name; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.manufacturer_code'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.masterSubCategoryCode'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.brand.name'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.subBrand.name'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($returnDetail, 'product.subBrandSeries.name'));  ?></td>
							<td><?php echo $returnDetail->qty_request == ''?'-':$returnDetail->qty_request; ?></td>
							<td><?php echo $returnDetail->qty_reject== ''?'-':$returnDetail->qty_reject; ?></td>
							<td><?php echo $returnDetail->note== ''?'-':$returnDetail->note; ?></td>
							<td><?php echo $returnDetail->barcode_product == ''?'-':$returnDetail->barcode_product; ?></td>
							<td><?php echo $returnDetail->quantity_movement; ?></td>
							<td><?php echo $returnDetail->quantity_movement_left; ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>	
		<?php else: ?>
			<?php echo 'No Details Available'; ?>
		<?php endif ?>
		<hr />
	</div>