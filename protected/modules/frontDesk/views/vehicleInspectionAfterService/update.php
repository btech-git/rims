<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs = array(
    'Front Desk',
    'Vehicle Inspections' => array('admin'),
    'Update Vehicle Inspection',
);

?>
<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'vehicleInspection' => $vehicleInspection,
//        'vehicleInspectionDetail' => $vehicleInspectionDetail,
//        'vehicleInspectionDetailDataProvider' => $vehicleInspectionDetailDataProvider,
    )); ?>
</div>
