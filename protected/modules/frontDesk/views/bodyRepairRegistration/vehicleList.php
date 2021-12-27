<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Body Repair Registration'=>array('admin'),
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
    <div class="clearfix page-action">
        <table style="border: 0px solid">
            <tr>
                <td style="width: 70%; border: 0px solid"><h1>List Customer + Vehicle</h1></td>
                <td style="border: 0px solid"><a class="button primary right" href="<?php echo Yii::app()->baseUrl.'/master/customer/create';?>"><span class="fa fa-plus"></span>New Customer</a></td>
                <td style="border: 0px solid"><?php echo CHtml::link('Manage', array('admin'), array('class'=>'button success right')); ?></td>
            </tr>
        </table>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'vehicle-grid',
                'dataProvider' => $vehicleDataProvider,
                'filter' => $vehicle,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                   'cssFile'=>false,
                   'header'=>'',
                ),
                'columns' => array(
                    array(
                        'header' => 'Customer',
                        'filter' => CHtml::textField('CustomerName', $customerName),
                        'value' => 'CHtml::link($data->customer->name, array("/master/customer/update", "id"=>$data->customer_id))',
                        'type'=>'raw',
                    ),
                    array(
                        'header' => 'Type',
                        'filter' => false,
                        'value' => 'CHtml::value($data, "customer.customer_type")',
                    ),
                    'plate_number',
                    array(
                        'header' => 'Car Make',
                        'name' => 'car_make_id',
                        'filter' => CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => ''
                        )),
                        'value' => 'CHtml::value($data, "carMake.name")',
                    ),
                    array(
                        'header' => 'Car Model',
                        'name' => 'car_model_id',
                        'filter' => CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => ''
                        )),
                        'value' => 'CHtml::value($data, "carModel.name")',
                    ),
                    array(
                        'header' => 'Car Sub Model',
                        'name' => 'car_sub_model_id',
                        'filter' => CHtml::activeDropDownList($vehicle, 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => ''
                        )),
                        'value' => 'CHtml::value($data, "carSubModel.name")',
                    ),
                    array(
                        'header' => 'Car Sub Model Detail',
                        'name' => 'car_sub_model_detail_id',
                        'filter' => CHtml::activeDropDownList($vehicle, 'car_sub_model_detail_id', CHtml::listData(VehicleCarSubModelDetail::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => ''
                        )),
                        'value' => 'CHtml::value($data, "carSubModelDetail.name")',
                    ),
                    array(
                        'header' => 'Color',
                        'name' => 'color_id',
                        'filter' => CHtml::activeDropDownList($vehicle, 'color_id', CHtml::listData(Colors::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => ''
                        )),
                        'value' => '$data->getColor($data, "color_id")',
                    ),
                    'machine_number',
                    array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => 'CHtml::link("Register", array("/frontDesk/generalRepairRegistration/create", "vehicleId"=>$data->id))',
                        'htmlOptions' => array(
                            'style' => 'text-align: center;'
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

