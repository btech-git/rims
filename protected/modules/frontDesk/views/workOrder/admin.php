<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Work Order',
	'Manage',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('admin')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('index')),
);

Yii::app()->clientScript->registerScript('search', "
/*$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});*/
$('form').submit(function(){
    $('#work-order-grid').yiiGridView('update', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        
        <h1>Work Orders</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="left clearfix bulk-action"></div>
                <div class="row">
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight: bold">Plate #</td>
                            <td style="text-align: center; font-weight: bold">Date</td>
                            <td style="text-align: center; font-weight: bold">Car Make</td>
                            <td style="text-align: center; font-weight: bold">Car Model</td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($model, 'plate_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            plate_number: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            <td>
                                <div class="medium-6 columns">
                                    <?php $attribute = 'transaction_date'; ?>
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$model,
                                        'attribute'=>$attribute."_from",
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date From',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                                    transaction_date_from: $(this).val(),
                                                    transaction_number: $("#' . CHtml::activeId($model, 'transaction_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                    transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                                    car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                    car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                                    work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                    status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                    repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                                <div class="medium-6 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$model,
                                        'attribute'=>$attribute."_to",
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date To',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                                    transaction_date_to: $(this).val(),
                                                    transaction_number: $("#' . CHtml::activeId($model, 'transaction_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                    transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                                    car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                    car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                                    work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                    status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                    repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'car_make_code', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            car_make_code: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                        } } });
                                    ' . CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                        'update' => '#car_model',
                                    )),
                                )); ?>
                            </td>
                            <td>
                                <div id="car_model">
                                    <?php echo CHtml::activeDropDownList($model, 'car_model_code', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => '
                                            $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                                car_model_code: $(this).val(),
                                                transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                                transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                                car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                                plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                                work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                                status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                                repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                                branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                            } } });
                                        ',
                                    )); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; font-weight: bold">WO #</td>
                            <td style="text-align: center; font-weight: bold">WO Status</td>
                            <td style="text-align: center; font-weight: bold">Type</td>
                            <td style="text-align: center; font-weight: bold">Branch</td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($model, 'work_order_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            work_order_number: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'status', array(
                                    ''=>'-- All --',
//                                    'Registration'=>'Registration',
//                                    'Pending'=>'Pending',
                                    'Waitlist'=>'Waitlist',
                                    'Processing WO'=>'Processing WO',
                                    'Assigned'=>'Assigned',
                                    'Finished'=>'Finished',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            status: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'repair_type', array(
                                    ''=>'-- All --',
                                    'GR'=>'GR',
                                    'BR'=>'BR',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            repair_type: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            <td>
                                <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
                                            branch_id: $(this).val(),
                                            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
                                            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
                                            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
                                            car_model_code: $("#' . CHtml::activeId($model, 'car_model_code') . '").val(),
                                            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
                                            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
                                            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'work-order-grid',
                'dataProvider'=>$modelDataProvider,
                'filter'=>null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
                'pager'=>array(
                   'cssFile'=>false,
                   'header'=>'',
                ),
                'columns'=>array(
                    array('name'=>'plate_number', 'value'=>'$data->vehicle->plate_number'),
                    array(
                        'name'=>'transaction_date',
                        'value'=>'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)',
                    ),
                    array(
                        'header'=>'Car Make',
                        'name'=>'car_make_code',
                        'value'=>'empty($data->vehicle->carMake) ? "" : $data->vehicle->carMake->name'
                    ),
                    array(
                        'header'=>'Car Model',
                        'name'=>'car_model_code',
                        'value'=>'empty($data->vehicle->carModel) ? "" : $data->vehicle->carModel->name'
                    ),
                    array(
                        'header'=>'Color',
                        'name'=>'car_color',
                        'value'=>'$data->vehicle->getColor($data->vehicle,"color_id")',
                        'filter'=>CHtml::dropDownList('RegistrationTransaction[car_color]', 'car_color', CHtml::listData(Colors::model()->findAll(),'id','name'), array('class'=>'form-control','empty'=>'--Select Color--')),
                    ),
                    'work_order_number',
                    'work_order_date',
                    array(
                        'header'=>'Services',
                        'name'=>'search_service',
                        'type'=>'html',
                        'value'=>'$data->getServices()',
                    ),
                    array(
                        'header'=>'Repair Type',
                        'name'=>'repair_type', 
                        'value'=>'$data->repair_type',
                        'type'=>'raw',
                        'filter'=>CHtml::dropDownList('RegistrationTransaction[repair_type]', $model->repair_type, array(
                            'GR'=>'General Repair',
                            'BR'=>'Body Repair',
                        ), array('class'=>'form-control','empty'=>'--Select Branch--')),
                    ),								
                    'problem',
                    array(
                        'header'=>'User',
                        'name'=>'user_id',
                        'value'=>'!empty($data->user->username)?$data->user->username:""',
                    ),
                    array(
                        'header'=>'Cabang',
                        'name'=>'branch_id',
                        'value'=>'$data->branch != "" ? $data->branch->name : ""',
                        'filter'=>CHtml::dropDownList('RegistrationTransaction[branch_id]', 'branch_name', CHtml::listData(Branch::model()->findAll(),'id','name'), array('class'=>'form-control','empty'=>'--Select Branch--')),
                    ),
                    array(
                        'header'=>'WO Status',
                        'name'=>'status', 
                        'value'=>'$data->status',
                        'type'=>'raw',
//                        'filter'=>CHtml::dropDownList('RegistrationTransaction[service_status]', $model->status, array(
//                            ''=>'All',
//                            'Pending'=>'Pending',
//                            'Available'=>'Available',
//                            'On Progress'=>'On Progress',
//                            'Finished'=>'Finished'
//                        )),
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{detail}',
                        'buttons'=>array (
                            'detail' => array (
                                'label'=>'view',
                                'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id"=>$data->id))',
                                //'options'=>array('class'=>'registration-service-view','id'=>''),
                                'visible'=>'Yii::app()->user->checkAccess("workOrderReport")',
                                'click'=>"js:function(){
                                    var url = $(this).attr('href');

                                    newwindow=window.open(url,'name','height=600,width=1200,left=100');
                                    if (window.focus) {newwindow.focus()}
                                    newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('work-order-grid')}
                                    newwindow.onunload = function(){  $.fn.yiiGridView.update('work-order-grid')}
                                    return false;
                                }"
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>