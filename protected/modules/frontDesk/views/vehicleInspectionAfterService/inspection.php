<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs = array(
    'Vehicle Inspections' => array('admin'),
    'Manage',
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
	$('#vehicle-inspection-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Vehicle Inspection', Yii::app()->baseUrl . '/frontDesk/vehicleInspection/create?vehicleId=' . $_GET['vehicleId'] . '&wonumber=' . $_GET['wonumber'], array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("frontDesk.vehicleInspection.create"))) ?>
        <h1>Manage Vehicle Inspections</h1>

        <?php echo $vehicle->customer->name . ' | ' . $vehicle->plate_number . ' | ' . $vehicle->frame_number ?>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="left clearfix bulk-action">
                    <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                    <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                    <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
                </div>
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
            </div>
        </div>

        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'vehicle-inspection-grid',
            'dataProvider' => $vehicleInspectionDataProvider,
            'filter' => $vehicleInspection,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                'inspection_date',
                array('name' => 'inspection_id', 'value' => '$data->inspection->name'),
                'status',
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => array(
                        'view' => array(
                            'visible' => 'Yii::app()->user->checkAccess("frontDesk.vehicleInspection.view")'
                        ),
                        'update' => array(
                            'label' => 'Update',
                            'url' => 'Yii::app()->createUrl("frontDesk/vehicleInspection/update", array("id"=>$data->id)) . "&vehicleId=$_GET[vehicleId]&wonumber=$_GET[wonumber]"',
                            'visible' => 'Yii::app()->user->checkAccess("frontDesk.vehicleInspection.update")'
                        ),
                        'delete' => array(
                            'visible' => 'Yii::app()->user->checkAccess("frontDesk.vehicleInspection.delete")'
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>