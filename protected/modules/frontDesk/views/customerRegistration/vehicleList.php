<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Customer Registration'=>array('admin'),
	'Vehicle List',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('#menushow').click(function(){
/*	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;*/
});
$('.search-form form').submit(function(){
	$('#registration-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <?php echo CHtml::beginForm(); ?>
	<div class="clearfix page-action">
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Vehicle' => array(
                        'content' => $this->renderPartial('_viewVehicle', array(
                            'vehicleDataProvider' => $vehicleDataProvider, 
                            'vehicle' => $vehicle, 
                        ), true),
                    ),
                    'Customer' => array(
                        'content' => $this->renderPartial('_viewCustomer', array(
                            'customerDataProvider' => $customerDataProvider, 
                            'customer' => $customer, 
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            )); ?>
	</div>
    <?php echo CHtml::endForm(); ?>
</div>