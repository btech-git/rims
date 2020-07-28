<?php
/* @var $this RegistrationTransactionController */
/* @var $registrationTransaction->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
	<!-- breadcrumbs end-->
	<div class="row">
		<div class="small-2 columns">
			<?php include Yii::app()->basePath . '/../css/navsettings.php'; ?>
		</div>
		<div class="small-10 columns">
			<div id="maincontent">
				<?php echo $this->renderPartial('_idle-management-update-form', array(
					'model'=>$model,
				)); ?>
			</div>
		</div>
	</div>