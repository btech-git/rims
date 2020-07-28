<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $model ConsignmentOutHeader */

$this->breadcrumbs=array(
	'Consignment Out Headers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ConsignmentOutHeader', 'url'=>array('admin')),
	array('label'=>'Create ConsignmentOutHeader', 'url'=>array('create')),
	array('label'=>'Update ConsignmentOutHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ConsignmentOutHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ConsignmentOutHeader', 'url'=>array('admin')),
);
?>

<!--<h1>View ConsignmentOutHeader #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Consignment Out', Yii::app()->baseUrl.'/transaction/consignmentOutHeader/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentOutHeader.admin"))) ?>
		
		<?php if ($model->status != 'Approved' && $model->status != 'Rejected'): ?>
			<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/consignmentOutHeader/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentOutHeader.update"))) ?>
				<?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/consignmentOutHeader/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.consignmentOutHeader.updateApproval"))) ?>
			<!-- <a class="button cbutton right" style="margin-right:10px;" href="<?php //echo Yii::app()->createUrl('/transaction/'.$ccontroller.'/updateStatus',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>Update Status</a> -->
			
		<?php endif ?>
		
		<h1>View ConsignmentOutHeader <?php echo $model->consignment_out_no; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'consignment_out_no',
		'date_posting',
		'status',
		array('name'=>'customer_name','value'=>$model->customer->name,),
		//'customer_id',
		'delivery_date',
		'sender_id',
		array('name'=>'branch_name','value'=>$model->branch->name,),

		//'branch_id',
		//'approved_id',
		'periodic',
		'total_quantity',
		'total_price',
			),
		)); ?>
	</div>
</div>
<br>
	
	<div class="detail">

		<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
			    'tabs' => array(
			        'Detail Item'=>array('id'=>'test1','content'=>$this->renderPartial(
                                        '_viewDetail',
                                        array('details'=>$details),TRUE)),
			        'Detail Approval'=>array('id'=>'test2','content'=>$this->renderPartial(
                                        '_viewDetailApproval',
                                        array('historis'=>$historis),TRUE)),
			       
			  ),                       
			       
			 
			    // additional javascript options for the tabs plugin
			    'options' => array(
			        'collapsible' => true,
			    ),
			    // set id for this widgets
			    'id'=>'view_tab',
			));
	?>
		
		
	</div>