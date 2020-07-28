<?php
/* @var $this EmployeeMobileController */
/* @var $model EmployeeMobile */

$this->breadcrumbs=array(
	'Company',
	'Employee Mobiles'=>array('admin'),
	'View Employee Mobile '.$model->id,
	
);

$this->menu=array(
	array('label'=>'List EmployeeMobile', 'url'=>array('index')),
	array('label'=>'Create EmployeeMobile', 'url'=>array('create')),
	array('label'=>'Update EmployeeMobile', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeMobile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeMobile', 'url'=>array('admin')),
);
?>

	
			<div id="maincontent">
				<div class="clearfix page-action">
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/employeeMobile/admin';?>"><span class="fa fa-plus"></span>Manage Employee Mobiles</a>
					<h1>View Employee Mobile <?php echo $model->id; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
							//'id',
							'employee_id',
							'mobile_no',
							'status',
						),
					)); ?>
				</div>
			</div>
