<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs=array(
	'Vehicle Inspections'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List VehicleInspection', 'url'=>array('index')),
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