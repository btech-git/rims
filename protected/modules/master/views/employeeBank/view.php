<?php
/* @var $this EmployeeBankController */
/* @var $model EmployeeBank */

$this->breadcrumbs=array(
	'Company',
	'Employee Banks'=>array('admin'),
	'View Employee Bank'.$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeBank', 'url'=>array('index')),
	array('label'=>'Create EmployeeBank', 'url'=>array('create')),
	array('label'=>'Update EmployeeBank', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeBank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeBank', 'url'=>array('admin')),
);
?>

	
			<div id="maincontent">
				<div class="clearfix page-action">
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/employeeBank/admin';?>"><span class="fa fa-plus"></span>Manage Employee Banks</a>
					
					<h1>View Employee Bank <?php echo $model->id; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
							//'id',
							'bank_id',
							'employee_id',
							'account_no',
							'account_name',
							'status',
						),
					)); ?>
				</div>
			</div>
