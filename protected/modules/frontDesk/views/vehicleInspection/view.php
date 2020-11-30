<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */

$this->breadcrumbs = array(
    'Vehicle Inspections' => array('admin'),
    $vehicleInspection->header->id,
);

$this->breadcrumbs = array(
    'Front Desk',
    'Vehicle Inspections' => array('admin'),
    'View Vehicle Inspection ' . $vehicleInspection->header->vehicle->plate_number,
);

/* $this->menu=array(
  array('label'=>'List VehicleInspection', 'url'=>array('index')),
  array('label'=>'Create VehicleInspection', 'url'=>array('create')),
  array('label'=>'Update VehicleInspection', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete VehicleInspection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage VehicleInspection', 'url'=>array('admin')),
  ); */
?>
<style>
    input[type=radio].red{
        outline: 1px solid red
    }
    input[type=radio].green{
        outline: 1px solid green
    }
    input[type=radio].yellow{
        outline: 1px solid yellow
    }
    input[type=radio].gray{
        outline: 1px solid gray
    }
</style>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-print"></span>Print Vehicle Inspection', Yii::app()->createUrl('/frontDesk/vehicleInspection/printPdf', array('id' => $vehicleInspection->header->id)), array('class' => 'button success', 'target' => '_blank', 'visible' => Yii::app()->user->checkAccess("frontDesk.vehicleInspection.admin"))) ?>
        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Vehicle Inspection', Yii::app()->baseUrl . '/frontDesk/vehicleInspection/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("frontDesk.vehicleInspection.admin"))) ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->createUrl('/frontDesk/' . $ccontroller . '/update', array('id' => $vehicleInspection->header->id)) . '&vehicleId=' . $vehicleInspection->header->vehicle_id . '&wonumber=' . $vehicleInspection->header->work_order_number, array('class' => 'button cbutton right', 'style' => 'margin-right: 10px', 'visible' => Yii::app()->user->checkAccess("frontDesk.vehicleInspection.update"))) ?>

        <h1>View <?php echo $vehicleInspection->header->vehicle->plate_number ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $vehicleInspection->header,
            'attributes' => array(
                'id',
                array(
                    'label' => 'Car Make',
                    'value' => $vehicleInspection->header->vehicle->carMake->name,
                ),
                array(
                    'label' => 'Car Model',
                    'value' => $vehicleInspection->header->vehicle->carModel->name,
                ),
                array(
                    'label' => 'Car Sub Model',
                    'value' => $vehicleInspection->header->vehicle->carSubModel->name,
                ),
                array(
                    'label' => 'Inspection Code',
                    'value' => $vehicleInspection->header->inspection->code,
                ),
                array(
                    'label' => 'Inspection Name',
                    'value' => $vehicleInspection->header->inspection->name,
                ),
                'inspection_date',
                'work_order_number',
                array(
                    'label' => 'Service Advisor',
                    'value' => $vehicleInspection->header->serviceAdvisor->username,
                ),
                'status',
            ),
        )); ?>
    </div>

    <h2>Vehicle Report</h2>
    <div class="grid-view" id="vehicleReport" >
        <table class="items">
            <thead>
                <tr>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody >
                <tr>
                    <span style="color: green">Checked and Okay At This Time</span> | <span style="color: yellow">May Need Future Attention</span> | <span style="color: red">Requires Immediate Attention<span> | <span style="color: gray">Not Inspected At This Time</span>
                </tr>
                <tr>
                    <td>
                        <?php foreach ($vehicleInspection->vehicleInspectionDetails as $i => $vehicleInspectionDetail): ?>
                            <!-- Start inspection loop -->
                            <?php
                            if ($i == 0) {
                                $section = $vehicleInspectionDetail->section_id;
                                echo '<p style="font-size: 1.5em; font-weight: bold; text-decoration: underline">' . $vehicleInspectionDetail->section->name . '<p>';
                            }

                            $currSection = $vehicleInspectionDetail->section_id;

                            if ($currSection != $section) {
                                $section = $vehicleInspectionDetail->section_id;
                                echo '<p style="font-size: 1.5em; font-weight: bold; text-decoration: underline">' . $vehicleInspectionDetail->section->name . '<p>';
                            }

                            $checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id' => $vehicleInspectionDetail->checklist_type_id));
                            ?>

                            <table>
                                <tr>
                                    <td style='width: 30%'><?php echo CHtml::encode(CHtml::value($vehicleInspectionDetail, 'module.name')); ?></td>
                                        <?php if ($vehicleInspectionDetail->checklistModule->type == 'Text'): ?>
                                            <td colspan="2"><?php echo CHtml::encode(CHtml::value($vehicleInspectionDetail, 'value')); ?></td>
                                        <?php else: ?>
                                        <td style='width: 30%'>
                                            PRE: &nbsp; &nbsp;
                                            <span style="color: <?php echo strtolower($vehicleInspectionDetail->checklistModule->color_indicator); ?>">
                                                <?php echo CHtml::encode(CHtml::value($vehicleInspectionDetail, 'checklistModule.name')); ?>
                                            </span>
                                        </td>
                                        <td style='width: 30%'>
                                            POST: &nbsp; &nbsp;
                                            <span style="color: <?php echo empty($vehicleInspectionDetail->checklist_module_id_after_service) ? 'black' : strtolower($vehicleInspectionDetail->checklistModuleAfterService->color_indicator); ?>">
                                                <?php echo CHtml::encode(CHtml::value($vehicleInspectionDetail, 'checklistModuleAfterService.name')); ?>
                                            </span>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix"></div><div style="display:none" class="keys"></div>
    </div>
</div>

