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
                <td style="border: 0px solid" colspan="4"><h1>List Customer + Vehicle</h1></td>
                <td style="border: 0px solid" colspan="2"><a class="button primary right" href="<?php echo Yii::app()->baseUrl.'/master/customer/create';?>"><span class="fa fa-plus"></span>New Customer</a></td>
                <td style="border: 0px solid" colspan="2"><?php echo CHtml::link('Manage', array('admin'), array('class'=>'button success right')); ?></td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>
                    <?php echo CHtml::activeCheckBox($vehicle, 'customer_name_checked', array(
                        'onchange' => '
                            if ($(this).prop("checked")) {
                                $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").prop("checked", false);
                                $("#' . CHtml::activeId($vehicle, 'plate_number') . '").prop("readonly", false);
                            }
                            $("#' . CHtml::activeId($vehicle, 'customer_name') . '").prop("readonly", $(this).prop("checked"));
                            $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val("");
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $(this).is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td colspan="3">
                    <?php echo CHtml::activeTextField($vehicle, 'customer_name', array(
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $(this).val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td>Type</td>
                <td colspan="3">
                    <?php echo CHtml::activeDropDownList($vehicle, 'customer_type', array(
                        'Individual' => 'Individual', 
                        'Company' => 'Company',
                    ), array(
                        'empty' => '-- All --',
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $(this).val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
            </tr>
            <tr>
                <td>No Polisi</td>
                <td>
                    <?php echo CHtml::activeCheckBox($vehicle, 'plate_number_checked', array(
                        'onchange' => '
                            if ($(this).prop("checked")) {
                                $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").prop("checked", false);
                                $("#' . CHtml::activeId($vehicle, 'customer_name') . '").prop("readonly", false);
                            }
                            $("#' . CHtml::activeId($vehicle, 'plate_number') . '").prop("readonly", $(this).prop("checked"));
                            $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val("");
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $(this).is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::activeTextField($vehicle, 'plate_number', array('readonly' => true,
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $(this).val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td>Merk</td>
                <td>
                    <?php echo CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $(this).val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td>Model</td>
                <td>
                    <?php echo CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $(this).val(),
                                car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
                <td>Sub Model</td>
                <td>
                    <?php echo CHtml::activeDropDownList($vehicle, 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => '
                            $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
                                customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
                                customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $(this).val(),
                                customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
                                plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
                            } } });
                        ',
                    )); ?>
                </td>
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
//                        'filter' => CHtml::textField('CustomerName', $customerName),
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

