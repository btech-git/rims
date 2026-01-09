<?php
/* @var $this VehicleCarModelController */
/* @var $model VehicleCarModel */

$this->breadcrumbs = array(
    'Vehicle Car Models' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List VehicleCarModel', 'url' => array('index')),
    array('label' => 'Create VehicleCarModel', 'url' => array('create')),
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
	$('#vehicle-car-model-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterCarModelCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarModel/create'; ?>" data-reveal-id="vehicle-model"><span class="fa fa-plus"></span>New Vehicle Car Models</a>
        <?php } ?>
        <h1>Manage Vehicle Car Models</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><!-- search-form -->	
            </div>
        </div>

        <div class="grid-view">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'vehicle-car-model-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                //'summaryText'=>'',
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '2',
                        'header' => 'Selected',
                        'value' => '$data->id',
                    ),
                    array(
                        'name' => 'car_make',
                        'filter' => CHtml::activeDropDownList($model, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => 'CHTml::link($data->carMake->name,Yii::app()->createUrl("master/vehicleCarMake/view",array("id"=>$data->car_make_id)))',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'name',
                        'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))',
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'service_group_id',
                        'value' => '$data->serviceGroup->name',
                        'type' => 'raw'
                    ),
                    'description',
                    'user.username',
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'value' => '$data->created_datetime',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array(
                            'edit' => array(
                                'label' => 'edit',
                                'visible' => '(Yii::app()->user->checkAccess("masterCarModelEdit"))',
                                'url' => 'Yii::app()->createUrl("master/vehicleCarModel/update", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>