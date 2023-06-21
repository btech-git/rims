<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */

$this->breadcrumbs=array(
	'Stock Adjustment Headers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StockAdjustmentHeader', 'url'=>array('index')),
	array('label'=>'Create StockAdjustmentHeader', 'url'=>array('create')),
	array('label'=>'Update StockAdjustmentHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StockAdjustmentHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StockAdjustmentHeader', 'url'=>array('admin')),
);
?>

<div id="maincontent">
<div class="clearfix page-action">
	<?php $ccontroller = Yii::app()->controller->id; $ccaction = Yii::app()->controller->action->id; ?>
	<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Stock Adjustment', Yii::app()->baseUrl.'/transaction/stockAdjustment/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.stockAdjustment.admin"))) ?>
	
	<?php if ($model->status == 'Draft' && Yii::app()->user->checkAccess("stockAdjustmentEdit")) : ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/stockAdjustment/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.stockAdjustment.update"))) ?>
	<?php endif ?>


<h1>View Stock Adjustment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'stock_adjustment_number',
		'date_posting',
		'branch_id',
		'user_id',
		'supervisor_id',
		'status',
		'note',
	),
)); ?>

<hr />
<h2>Detail Product</h2>
<div class="row">
	<div class="small-12 columns">
	<div style="max-width: 90em; width: 100%;">
		<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
		<?php $this->renderPartial('_detailView', array('model'=>$model,'modelDetail'=>$modelDetail,'warehouse'=>$warehouse)); ?>
		</div>
	</div>
	</div>
</div>

<hr />

<div class="row">
	<div class="small-12 columns">
		<?php $this->renderPartial('_approval', array('listApproval'=>$listApproval)); ?>
	</div>
</div>
</div></div>