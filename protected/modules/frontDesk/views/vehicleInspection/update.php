<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs=array(
	'Front Desk',
	'Vehicle Inspections'=>array('admin'),
	'Update Vehicle Inspection',
);

/*$this->menu=array(
	array('label'=>'List VehicleInspection', 'url'=>array('index')),
	array('label'=>'Create VehicleInspection', 'url'=>array('create')),
	array('label'=>'View VehicleInspection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicleInspection', 'url'=>array('admin')),
);*/
?>
		<div id="maincontent">
			<?php $this->renderPartial('_form', array(
					//'model'=>$model,
					'vehicleInspection'=>$vehicleInspection,
					'vehicleInspectionDetail'=>$vehicleInspectionDetail,
					'vehicleInspectionDetailDataProvider'=>$vehicleInspectionDetailDataProvider,
					//'sectionArray'=>$sectionArray,
				)); 
			?>
		</div>
