<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $model VehicleCarSubModelDetail */

$this->breadcrumbs = array(
    'Vehicle' => Yii::app()->baseUrl . '/master/vehicle/admin',
    'Vehicle Car Sub Model Details' => array('admin'),
    'Manage Vehicle Car Sub Model Details',
);

/* $this->menu=array(
  array('label'=>'List VehicleCarSubModelDetail', 'url'=>array('index')),
  array('label'=>'Create VehicleCarSubModelDetail', 'url'=>array('create')),
  ); */

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
	$('#vehicle-car-sub-model-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterCarSubModelDetailCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarSubModelDetail/create'; ?>" data-reveal-id="vehicle-subbrand-det"><span class="fa fa-plus"></span>New Vehicle Car Sub Model Details</a>
        <?php } ?>
        <h1>Manage Vehicle Car Sub Model Details</h1>

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
                'id' => 'vehicle-car-sub-model-detail-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
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
                    array('name' => 'car_sub_model_name', 'value' => '$data->carSubModel->name'),
                    array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                    //'name',
                    'chasis_code',
                    'assembly_year_start',
                    'assembly_year_end',
                    'transmission',
                    'fuel_type',
                    'power',
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'value' => '$data->created_datetime',
                    ),
                    /*
                      'drivetrain',
                      'description',
                      'status',
                      'luxury_value',
                     */
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array
                            (
                            'edit' => array
                                (
                                'label' => 'edit',
                                'url' => 'Yii::app()->createUrl("master/vehicleCarSubModelDetail/update", array("id"=>$data->id))',
                                'visible' => '(Yii::app()->user->checkAccess("masterCarSubModelDetailEdit"))'
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>