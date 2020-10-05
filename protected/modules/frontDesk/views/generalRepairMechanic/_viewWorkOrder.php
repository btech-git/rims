<div style="height: 350px">
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
        <?php $inspectionModel = VehicleInspection::model()->findByAttributes(array('work_order_number' => $registration->work_order_number)); ?>
        <?php if (!empty($inspectionModel)): ?>
            <tr>
                <td>
                    Inspection: <?php echo CHtml::link($inspectionModel->inspection->name, array("/frontDesk/vehicleInspection/view", "id"=>$inspectionModel->id), array("target" => "_blank")); ?>
                </td>
                <td>Status: <?php echo $inspectionModel->status; ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td colspan="2">
                Tambah Memo: 
                <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
            </td>
        </tr>
    </table>
</div>