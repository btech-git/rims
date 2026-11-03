<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'General Repair Registration'=>array('admin'),
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
                <td style="border: 0px solid" colspan="2"><h1>List Customer + Vehicle</h1></td>
                <td style="border: 0px solid" colspan="2"><?php echo CHtml::link('+ Vehicle', array('customerVehicle/create'), array('class'=>'button success left')); ?></td>
                <td style="border: 0px solid" colspan="2"><?php echo CHtml::link('Manage', array('admin'), array('class'=>'button cbutton right')); ?></td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>
                    <?php echo CHtml::activeDropDownList($vehicle, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                        'condition' => 't.status = "Active" AND t.id IN (60849, 60926, 63482)',
                        'order' => 't.name ASC',
                    )), 'id', 'name'), array(
                        'empty' => 'All',
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_id: $(this).val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                            } } });
                        ',
                    )); ?>
                </td>
                <td>No Polisi</td>
                <td>
                    <?php echo CHtml::activeTextField($vehicle, 'plate_number', array(
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_id: $("#' . CHtml::activeId($vehicle, 'customer_id') . '").val(),
                                plate_number: $(this).val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                            } } });
                        ',
                    )); ?>
                </td>
                <td>Model</td>
                <td>
                    <div id="car_model">
                        <?php echo CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array(
                            'condition' => 'status = "Active" AND t.car_make_id = 72',
                            'params' => array(':car_make_id' => $vehicle->car_make_id),
                            'order' => 't.name ASC',
                        )), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'onchange' => '
                                $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                    car_model_id: $(this).val(),
                                    customer_id: $("#' . CHtml::activeId($vehicle, 'customer_id') . '").val(),
                                    plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                    car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                } } });
                            ',
                        )); ?>
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'vehicle-grid',
                'dataProvider' => $vehicleDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                   'cssFile'=>false,
                   'header'=>'',
                ),
                'columns' => array(
                    array(
                        'header' => 'Customer',
                        'value' => 'CHtml::link($data->customer->name, array("/master/customer/update", "id"=>$data->customer_id))',
                        'type'=>'raw',
                    ),
                    'plate_number',
                    array(
                        'header' => 'Car Make',
                        'name' => 'car_make_id',
                        'value' => 'CHtml::value($data, "carMake.name")',
                    ),
                    array(
                        'header' => 'Car Model',
                        'name' => 'car_model_id',
                        'value' => 'CHtml::value($data, "carModel.name")',
                    ),
                    array(
                        'header' => 'Car Sub Model',
                        'name' => 'car_sub_model_id',
                        'value' => 'CHtml::value($data, "carSubModel.name")',
                    ),
                    array(
                        'header' => 'Color',
                        'name' => 'color_id',
                        'value' => '$data->getColor($data, "color_id")',
                    ),
                    'machine_number',
                    array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => 'CHtml::link("Register", array("create", "vehicleId"=>$data->id))',
                        'htmlOptions' => array(
                            'style' => 'text-align: center;'
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

