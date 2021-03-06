<div style="height: 470px">
    <h1>Work Order Information</h1>
    <?php
        $duration = 0;
        $damage = "";
        $registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$registration->id,'is_body_repair'=>1));
        foreach ($registrationServiceBodyRepairs as $rs) {
            $duration += $rs->hour;
        }
        $registrationDamages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id'=>$registration->id));
        foreach ($registrationDamages as $key => $registrationDamage) {
            $damage .= $registrationDamage->service->name;
            $damage .= ",";
        }
    ?>
    <?php $vehicle = $registration->vehicle; ?>
    <table>
        <tr>
            <td style="width: 50%">Plate Number: <?php echo $registration->vehicle->plate_number; ?></td>
            <td>Problem : <?php echo $registration->problem; ?></td>
        </tr>
        <tr>
            <td>Car Make: <?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
            <td>Total Duration: <?php echo $duration . ' hr'; ?></td>
        </tr>
        <tr>
            <td>Car Model: <?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
            <td>Last Update By: <?php echo $registration->user->username; ?></td>
        </tr>
        <tr>
            <td>Work Order #: <?php echo $registration->work_order_number; ?></td>
            <td>Status: <?php echo $registration->status; ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top">
                Quality Control: <br />
                <?php if ($registration->is_passed == 0): ?>
                    <?php echo CHtml::activeRadioButtonList($registration, 'is_passed', array(
                        '0' => 'Failed',
                        '1' => 'Passed'
                    ), array(
                        'labelOptions' => array(
                            'style' => 'display:inline',
                            'separator' => ' | ',
                        )
                    )); ?>
                    <?php echo CHtml::error($registration,'is_passed'); ?>
                <?php else: ?>
                    <?php echo 'Passed'; ?>
                <?php endif; ?> <br /><br />
                <?php $inspection = VehicleInspection::model()->findByAttributes(array(
                    'work_order_number' => $registration->work_order_number, 
                    'vehicle_id' => $registration->vehicle_id,
                )); ?>
                <?php echo empty($inspection) ? '' : CHtml::link('Process Inspection', array("/frontDesk/vehicleInspectionAfterService/update", "id"=>$inspection->id), array("target" => "_blank", 'class' => 'button warning')); ?>
            </td>
            <td>
                Priority: <br />
                <?php echo CHtml::activeRadioButtonList($registration, 'priority_level', array(
                     RegistrationTransaction::PRIORITY_HIGH => RegistrationTransaction::PRIORITY_HIGH_LITERAL,
                     RegistrationTransaction::PRIORITY_MEDIUM => RegistrationTransaction::PRIORITY_MEDIUM_LITERAL,
                     RegistrationTransaction::PRIORITY_LOW => RegistrationTransaction::PRIORITY_LOW_LITERAL,
                )); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tambah Memo: 
                <?php echo CHtml::textField('Memo', $memo); ?> <br />
                <?php echo CHtml::submitButton('Save', array('name' => 'Save', 'confirm' => 'Are you sure you want to add note?', 'class' => 'button primary')); ?>
            </td>
        </tr>
    </table>
</div>