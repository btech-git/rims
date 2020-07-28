<?php
/* @var $this CompanyBankController */
/* @var $model CompanyBank */

$this->breadcrumbs=array(
	'Company Banks'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CompanyBank', 'url'=>array('index')),
	array('label'=>'Create CompanyBank', 'url'=>array('create')),
	array('label'=>'Update CompanyBank', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CompanyBank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompanyBank', 'url'=>array('admin')),
);
?>

<h1>View CompanyBank #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'bank_id',
		'account_no',
		'account_name',
		'status',
	),
)); ?>
