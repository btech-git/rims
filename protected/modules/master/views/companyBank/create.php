<?php
/* @var $this CompanyBankController */
/* @var $model CompanyBank */

$this->breadcrumbs=array(
	'Company Banks'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompanyBank', 'url'=>array('index')),
	array('label'=>'Manage CompanyBank', 'url'=>array('admin')),
);
?>

<h1>Create CompanyBank</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>