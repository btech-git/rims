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

<table class="items">
<!--    <thead>
        <tr>
            <th colspan="2"></th>
        </tr>
    </thead>-->
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
                        echo '<p style="background-color: #aaa">' . $vehicleInspectionDetail->section->name . '<p>';
                    }

                    $currSection = $vehicleInspectionDetail->section_id;

                    if ($currSection != $section) {
                        $section = $vehicleInspectionDetail->section_id;
                        echo '<p style="background-color: #aaa">' . $vehicleInspectionDetail->section->name . '<p>';
                    }

                    //Print hidden fields
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]section_id", array('value' => $vehicleInspectionDetail->section_id));
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]module_id", array('value' => $vehicleInspectionDetail->module_id));
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]checklist_type_id", array('value' => $vehicleInspectionDetail->checklist_type_id));


                    $checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id' => $vehicleInspectionDetail->checklist_type_id));

                    $text = '';
                    $checked = '';
                    $radio = '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id_after_service">';

                    foreach ($checklistTypeModules as $key => $checklistTypeModule) {
                        if ($checklistTypeModule->checklistType->type == "Radio") {
                            if ($vehicleInspectionDetail->checklist_module_id_after_service == $checklistTypeModule->checklist_module_id) {
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }

//                            $radio .= CHtml::activeRadioButtonList($vehicleInspectionDetail, "[$i]checklist_module_id_after_service", array(
//                                '0' => 'Failed',
//                                '1' => 'Passed'
//                            ), array(
//                                'labelOptions' => array(
//                                    'style' => 'display:inline',
//                                    'separator' => ' | ',
//                                )
//                            )); 
                            $radio .= '<input id="VehicleInspectionDetail_' . $i . '_checklist_module_id_after_service_' . $i . '" class="' . strtolower($checklistTypeModule->checklistModule->color_indicator) . '" value="' . $checklistTypeModule->checklist_module_id . '" ' . $checked . ' name="VehicleInspectionDetail[' . $i . '][checklist_module_id_after_service]" type="radio">' . CHtml::activeLabel($vehicleInspectionDetail, "[$i]checklist_module_id_after_service", array('label' => $checklistTypeModule->checklistType->show_label == 'Yes' ? $checklistTypeModule->checklistModule->name : '', 'style' => 'display:inline')) . '<label style="display:inline;" for="VehicleInspectionDetail_' . $i . '_checklist_module_id_after_service_' . $i . '"></label>';
                        } else {
                            $text .= CHtml::activeTextField($vehicleInspectionDetail, "[$i]value_after_service") . CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]checklist_module_id_after_service");
                        }
                    }
                    $radio .= '</span>';

                    if ($radio != '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id_after_service"></span>') {
                        echo $radio . '<span style="font-weight:bold">' . $vehicleInspectionDetail->module->name . '</span> || <span style="color: '. strtolower($vehicleInspectionDetail->checklistModule->color_indicator) .'">' . CHtml::encode(CHtml::value($vehicleInspectionDetail, 'checklistModule.name')) . '</span> ' . CHtml::error($vehicleInspectionDetail, "[$i]checklist_module_id_after_service") . '<br />';
                    }

                    if ($text != '') {
                        echo "<span>" . $vehicleInspectionDetail->module->name . "</span>" . $text . "<br />";
                    }
                    ?>
                <?php endforeach; ?>
            </td>
        </tr>
    </tbody>
</table>