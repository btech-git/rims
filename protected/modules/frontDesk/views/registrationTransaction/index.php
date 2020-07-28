<?php
/* @var $this RegistrationTransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registration Transactions',
);

$this->menu=array(
	//array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>

<h1>Registration Transactions</h1>

<?php echo $this->renderPartial('_find', array(
        'model'=>$model,
		'customer'=>$customer,
		'customerDataProvider'=>$customerDataProvider,
		'vehicle'=>$vehicle,
		'vehicleDataProvider'=>$vehicleDataProvider,
        'customerCompany' => $customerCompany,
)); ?>
<?php //$this->widget('zii.widgets.CListView', array(
	// 'dataProvider'=>$dataProvider,
	// 'itemView'=>'_view',
	// )); 
?>
