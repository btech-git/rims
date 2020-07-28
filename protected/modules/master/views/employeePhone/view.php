<?php
/* @var $this EmployeePhoneController */
/* @var $model EmployeePhone */

$this->breadcrumbs=array(
	'Company',
	'Employee Phones'=>array('admin'),
	'View Employee Phone '.$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeePhone', 'url'=>array('index')),
	array('label'=>'Create EmployeePhone', 'url'=>array('create')),
	array('label'=>'Update EmployeePhone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeePhone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeePhone', 'url'=>array('admin')),
);
?>

	
			<div id="maincontent">
				<div class="clearfix page-action">
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/employeePhone/admin';?>"><span class="fa fa-plus"></span>Manage Employee Phones</a>
					<h1>View Employee Phone <?php echo $model->id; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
							//'id',
							'employee_id',
							'phone_no',
							'status',
						),
					)); ?>
				</div>
			</div>