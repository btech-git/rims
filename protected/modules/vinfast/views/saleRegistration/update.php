<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/vinfast/saleRegistration/admin';?>">
            <span class="fa fa-th-list"></span>Manage
        </a>
        
        <h1>Update Data Transaction</h1>
        
        <?php echo $this->renderPartial('_formUpdateTransaction', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        )); ?>
    </div>
</div>