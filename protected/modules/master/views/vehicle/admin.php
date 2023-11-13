<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicle'=>array('admin'),
	'Vehicles'=>array('admin'),
	'Manage Customer Vehicles',
);

$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#vehicle-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterVehicleCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/vehicle/create';?>"><span class="fa fa-plus"></span>New Vehicle</a>
        <?php }?>
            
        <h1>Manage Customer Vehicles</h1>

        <div class="search-bar">
<!--            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
            </div>-->

            <div class="clearfix"></div>
            
            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search',array(
                    'model'=>$model,
                ));*/ ?>
            </div><!-- search-form -->
        </div>
			
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'vehicle-grid',
            'dataProvider'=>$dataProvider,
            'filter'=>$model,
            // 'summaryText' => '',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
               'cssFile'=>false,
               'header'=>'',
            ),
            'columns'=>array(
                array (
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '2',	
                    'header' => 'Selected',	
                    'value' => '$data->id',				
                ),
                'id',
                array(
                    'name'=>'plate_number', 
                    'value'=>'CHTml::link($data->plate_number, array("view", "id"=>$data->id))', 
                    'type'=>'raw'
                ),
                array(
                    'name'=>'customer_id',
                    'header' => 'Customer ID',
                    'filter' => CHtml::textField('CustomerId', $customerId),
                    'value'=>'CHtml::encode(CHtml::value($data, "customer_id"))'
                ),
                array(
                    'name'=>'customer_name',
                    'header' => 'Customer Name',
                    'filter' => CHtml::textField('CustomerName', $customerName),
                    'value'=>'CHtml::encode(CHtml::value($data, "customer.name"))'
                ),
                array(
                    'header' => 'Type',
                    'filter' => CHtml::dropDownList('CustomerType', $customerType, array(
                        'Company' => 'Company', 
                        'Individual' => 'Individual'
                    ), array('empty' => '-- All --')),
                    'value'=>'CHtml::encode(CHtml::value($data, "customer.customer_type"))'
                ),
                'machine_number',
                'frame_number',
                array(
                    'name'=>'car_make_id',
                    'header' => 'Car Make',
                    'filter' => CHtml::activeDropDownList($model, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value'=>'empty($data->car_make_id) ? "" : $data->carMake->name'
                ),
                array(
                    'name'=>'car_model_id',
                    'filter' => CHtml::activeDropDownList($model, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value'=>'empty($data->car_model_id) ? "" : $data->carModel->name'
                ),
                array(
                    'name'=>'car_sub_model_id',
                    'filter' => CHtml::activeDropDownList($model, 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value'=>'empty($data->car_sub_model_id) ? "" : $data->carSubModel->name'
                ),
                array(
                    'name'=>'color_id',
                    'header'=>'Color',
                    'value'=>array($model,'getColor'),
                    'filter'=>CHtml::textField('Vehicle[color_id]', ''),					
                ),				
                'year',
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{edit} {inspection}',
                    'buttons'=>array (
                        'edit' => array (
                            'visible'=>'(Yii::app()->user->checkAccess("master.vehicle.update"))',
                            'label'=>'edit',
                            'url'=>'Yii::app()->createUrl("master/vehicle/update", array("id"=>$data->id))',
                        ),
                        'inspection' => array (
                            'visible'=>'(Yii::app()->user->checkAccess("master.vehicle.inspection"))',
                            'label'=>'inspection',
                            'url'=>'Yii::app()->createUrl("master/vehicle/inspection", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>
<!-- end maincontent -->