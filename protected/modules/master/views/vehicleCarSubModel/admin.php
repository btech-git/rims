<?php
/* @var $this VehicleCarSubModelController */
/* @var $model VehicleCarSubModel */

$this->breadcrumbs = array(
    'Vehicle' => Yii::app()->baseUrl . '/master/vehicle/admin',
    'Vehicle Car Sub Models' => array('admin'),
    'Manage Vehicle Car Sub Models',
);

/* $this->menu=array(
  array('label'=>'List VehicleCarSubModel', 'url'=>array('index')),
  array('label'=>'Create VehicleCarSubModel', 'url'=>array('create')),
  );
 */
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
	$('#vehicle-car-sub-Model-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<div class="row">
        <div class="small-12 columns">
                <div class="breadcrumbs">
                        <a href="<?php echo Yii::app()->baseUrl . '/site/index'; ?>">Home</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>">Vehicle</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarSubModel/admin'; ?>">Vehicle Car Sub Model</a>
                        <span>Manage Vehicle Car Sub Model</span>
                </div>
        </div>
</div>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterCarSubModelCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarSubModel/create'; ?>" data-reveal-id="vehicle-subbrand-det"><span class="fa fa-plus"></span>New Vehicle Car Sub Models</a>
        <?php } ?>
        <h1>Manage Vehicle Car Sub Models</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <!--<div class="left clearfix bulk-action">
                        <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                        <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                        <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
                </div>-->
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
                'id' => 'vehicle-car-sub-model-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                // 'summaryText'=>'',
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
                        'value' => '$data->carMake->name'
                    ),
                    array(
                        'name' => 'car_model',
                        'filter' => CHtml::activeDropDownList($model, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->carModel->name'
                    ),
                    array(
                        'name' => 'name', 
                        'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'value' => '$data->created_datetime',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array
                            (
                            'edit' => array
                                (
                                'label' => 'edit',
                                'visible' => '(Yii::app()->user->checkAccess("masterCarSubModelEdit"))',
                                'url' => 'Yii::app()->createUrl("master/vehicleCarSubModel/update", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>