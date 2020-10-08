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
                    <!-- <th><a href="#" class="sort-link">Level</a></th>
                    <th><a href="#" class="sort-link"></a></th> -->
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
                                echo '<p style="background-color: #aaa; font-size: 1.5em">' . $vehicleInspectionDetail->section->name . '<p>';
                            }

                            $currSection = $vehicleInspectionDetail->section_id;

                            if ($currSection != $section) {
                                $section = $vehicleInspectionDetail->section_id;
                                echo '<p style="background-color: #aaa; font-size: 1.5em">' . $vehicleInspectionDetail->section->name . '<p>';
                            }

                            //Print hidden fields
                            echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]section_id", array('value' => $vehicleInspectionDetail->section_id));
                            echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]module_id", array('value' => $vehicleInspectionDetail->module_id));
                            echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]checklist_type_id", array('value' => $vehicleInspectionDetail->checklist_type_id));


                            $checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id' => $vehicleInspectionDetail->checklist_type_id));

                            $text = '';
                            $checked = '';
                            $radio = '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id">';

                            foreach ($checklistTypeModules as $key => $checklistTypeModule) {
                                if ($checklistTypeModule->checklistType->type == "Radio") {
                                    if ($vehicleInspectionDetail->checklist_module_id == $checklistTypeModule->checklistModule->id) {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }

                                    $radio .= '<input id="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '" class="' . strtolower($checklistTypeModule->checklistModule->color_indicator) . '" value="' . $checklistTypeModule->checklistModule->id . '" ' . $checked . ' disabled name="VehicleInspectionDetail[' . $i . '][checklist_module_id]" type="radio">' . CHtml::activeLabel($vehicleInspectionDetail, "[$i]checklist_module_id", array('label' => $checklistTypeModule->checklistType->show_label == 'Yes' ? $checklistTypeModule->checklistModule->name : '', 'style' => 'display:inline')) . '<label style="display:inline;" for="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '"></label>';
                                } else {
                                    $text .= '<br /> <span style="font-weight: bold">Pre Inspection:</span> ' . CHtml::encode(CHtml::value($vehicleInspectionDetail, "value")) . ' || <span style="font-weight: bold">Post Service:</span> ' .  CHtml::encode(CHtml::value($vehicleInspectionDetail, "value_after_service")) . '<br />';
                                }
                            }
                            $radio .= '</span>';

                            if ($radio != '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id"></span>') {
                                echo 'Pre Inspection: ' . $radio . $vehicleInspectionDetail->module->name . ' || Post Service: <span style="color: '. strtolower($vehicleInspectionDetail->checklistModule->color_indicator) .'">' . CHtml::encode(CHtml::value($vehicleInspectionDetail, 'checklistModuleAfterService.name')) . '</span> <br />';
                            }

                            if ($text != '') {
                                echo '<span style="font-weight: bold; font-size: larger">' . $vehicleInspectionDetail->module->name . '</span>' . $text . "<br />";
                            }
                            ?>

                        <?php endforeach ?>

                    </td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix"></div><div style="display:none" class="keys"></div>
    </div>
</div>

