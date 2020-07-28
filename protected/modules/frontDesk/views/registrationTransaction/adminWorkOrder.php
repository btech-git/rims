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

<div id="maincontent">
	<div class="clearfix page-action">
		<h1>Work Orders</h1>

		<div class="search-bar">
			<div class="clearfix button-bar">
				<div class="left clearfix bulk-action"></div>
				<div class="row">
                    <table>
                        <tr>
                            <td>Plate #</td>
                            <td>Date</td>
                            <td>Car Make</td>
                            <td>Car Model</td>
                            <td>WO #</td>
                            <td>WO Status</td>
                            <td>Type</td>
                            <td>Branch</td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::activeTextField($model,'transaction_number'); ?></td>
                            <td>
                                <?php $attribute = 'transaction_date'; ?>
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'id'=>CHtml::activeId($model, $attribute.'_0'),
                                    'model'=>$model,
                                    'attribute'=>$attribute."_from",
                                    'options'=>array('dateFormat'=>'yy-mm-dd'),
                                    'htmlOptions'=>array(
                                        'style'=>'margin-bottom:0px;',
                                        'placeholder'=>'Transaction Date From'
                                    ),
                                )); ?> - 
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'id'=>CHtml::activeId($model, $attribute.'_1'),
                                    'model'=>$model,
                                    'attribute'=>$attribute."_to",
                                    'options'=>array('dateFormat'=>'yy-mm-dd'),
                                    'htmlOptions'=>array(
                                        'style'=>'margin-bottom:0px;',
                                        'placeholder'=>'Transaction Date To'
                                    ),
                                )); ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php echo CHtml::dropDownList('RegistrationTransaction[status]', $model->status, array(
                                    ''=>'All',
                                    'Registration'=>'Registration',
                                    'Pending'=>'Pending',
                                    'Available'=>'Available',
                                    'On Progress'=>'On Progress',
                                    'Finished'=>'Finished'
                                ), array("style"=>"margin-bottom:0px;")); ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
     		</div>
     	</div>
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'work-order-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',				
                    'pager'=>array(
                       'cssFile'=>false,
                       'header'=>'',
                    ),
                    'columns'=>array(
                        //'id',
                        //array('name'=>'work_order_number', 'value'=>'CHTml::link($data->work_order_number, array("viewWo", "id"=>$data->id))', 'type'=>'raw'),
                        array('name'=>'plate_number', 'value'=>'$data->vehicle->plate_number'),
                        array(
                            'name'=>'transaction_date',
                            'value'=>'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)',
                            // 'filter'=>false, // Set the filter to false when date range searching
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
                            /*'value'=> function($data) {
                                $services = array();

                                if($data->repair_type == 'GR'){
                                    foreach ($data->registrationServices as $registrationService) {

                                        $services[] = $registrationService->service->name . '<br>';
                                    }
                                }
                                else{
                                    foreach ($data->registrationServices as $registrationService) {
                                        if($registrationService->is_body_repair == 1)
                                            $services[] = $registrationService->service->name . '<br>';
                                    }
                                }

                                return implode('', $services);
                            }*/
                            'value'=>'$data->getServices()',
                        ),
                        // 'repair_type',
                        array(
                            'header'=>'Repair Type',
                            'name'=>'repair_type', 
                            'value'=>'$data->repair_type',
                            'type'=>'raw',
                            'filter'=>CHtml::dropDownList('RegistrationTransaction[repair_type]', $model->repair_type, 
                                array(
                                    'GR'=>'General Repair',
                                    'BR'=>'Body Repair',
                                ), array('class'=>'form-control','empty'=>'--Select Branch--')
                            ),
                        ),								
                        'problem',

                        // 'user_id',
                        array(
                            'header'=>'User',
                            'name'=>'user_id',
                            'value'=>'!empty($data->user->username)?$data->user->username:""',
                        ),
                        // 'branch_id',
                        // array(
                        // 	'header'=>'User',
                        // 	'value'=>'$data->user->name',
                        // ),
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
                            'filter'=>CHtml::dropDownList('RegistrationTransaction[status]', $model->status, 
                                array(
                                    ''=>'All',
                                    'Pending'=>'Pending',
                                    'Available'=>'Available',
                                    'On Progress'=>'On Progress',
                                    'Finished'=>'Finished'
                                )
                            ),
                        ),
                        array(
                            'class'=>'CButtonColumn',
                                    'template'=>'{detail}',
                                    'buttons'=>array (
                                        'detail' => array (
                                            'label'=>'view',
                                            'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/viewWo", array("id"=>$data->id))',
                                            //'options'=>array('class'=>'registration-service-view','id'=>''),
                                            'visible'=>'Yii::app()->user->checkAccess("frontDesk.registrationTransaction.viewWo")',
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


<?php 
  Yii::app()->clientScript->registerScript('search',"

        $('#RegistrationTransaction_status,#RegistrationTransaction_transaction_date_1').change(function(){

        	console.log($('#search_heading-range').serialize());
        	// if ($('#RegistrationTransaction_transaction_date_0').val().lenght != 0) {
	            $.fn.yiiGridView.update('work-order-grid', {
	                data: $('#search_heading-range').serialize()
	            });
        	// }
            return false;
        });

		
    ");
?>