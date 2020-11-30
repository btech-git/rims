<style>
/*
    .custom-radios div {
  display: inline-block;
}
.custom-radios input[type="radio"] {
  display: none;
}
.custom-radios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radios input[type="radio"] + label span {
  display: inline-block;
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
}
.custom-radios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}
.custom-radios input[type="radio"].red + label span {
  background-color: #2ecc71;
}
.custom-radios input[type="radio"].green + label span {
  background-color: #3498db;
}
.custom-radios input[type="radio"].yellow + label span {
  background-color: #f1c40f;
}
.custom-radios input[type="radio"].gray + label span {
  background-color: #e74c3c;
}
.custom-radios input[type="radio"]:checked + label span img {
  opacity: 1;
} */
    input[type=radio].red{
  display: none;
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
  display: inline-block;
  width: 40px;
  height: 40px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 44px;
  opacity: 0;
  transition: all .3s ease;
  background-color: #2ecc71;
    }
    input[type=radio].green{
        outline: 1px solid green;
    }
    input[type=radio].yellow{
        outline: 1px solid yellow;
    }
    input[type=radio].gray{
        outline: 1px solid gray;
    }
</style>

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

                    //Print hidden fields
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]section_id", array('value' => $vehicleInspectionDetail->section_id));
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]module_id", array('value' => $vehicleInspectionDetail->module_id));
                    echo CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]checklist_type_id", array('value' => $vehicleInspectionDetail->checklist_type_id));

                    $checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id' => $vehicleInspectionDetail->checklist_type_id));

                    $text = '';
                    $checked = '';
                    $radio = '<div class="custom-radios"><div>';

                    foreach ($checklistTypeModules as $key => $checklistTypeModule) {
                        if ($checklistTypeModule->checklistType->type == "Radio") {
                            if ($vehicleInspectionDetail->checklist_module_id == $checklistTypeModule->checklistModule->id) {
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }

                            $radio .= '<input id="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '" class="' . strtolower($checklistTypeModule->checklistModule->color_indicator) . '" value="' . $checklistTypeModule->checklistModule->id . '" ' . $checked . ' name="VehicleInspectionDetail[' . $i . '][checklist_module_id]" type="radio">' . CHtml::activeLabel($vehicleInspectionDetail, "[$i]checklist_module_id", array('label' => $checklistTypeModule->checklistType->show_label == 'Yes' ? $checklistTypeModule->checklistModule->name : '', 'style' => 'display:inline')) . '<label style="display:inline;" for="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '"></label>';
                        } else {
                            $text .= CHtml::activeTextField($vehicleInspectionDetail, "[$i]value") . CHtml::activeHiddenField($vehicleInspectionDetail, "[$i]checklist_module_id", array('value' => $checklistTypeModule->checklistModule->id));
                        }
                    }
                    $radio .= '</div></div>';

                    if ($radio != '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id"></span>') {
                        echo $radio . $vehicleInspectionDetail->module->name . CHtml::error($vehicleInspectionDetail, "[$i]checklist_module_id") . '<br />';
                    }

                    if ($text != '') {
                        echo $text . "<br />";
                    }
                    ?>

                <?php endforeach; ?>
            </td>
        </tr>
    </tbody>
</table>