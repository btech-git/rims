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
            <td>Plate Number: <?php echo $registration->vehicle->plate_number; ?></td>
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
            <?php echo CHtml::beginForm(); ?>
            <td>
                Tambah Memo: 
                <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
            </td>
            <?php echo CHtml::endForm(); ?>
            <td>
                List Memo
                <table>
                    <?php foreach ($registration->registrationMemos as $i => $detail): ?>
                        <tr>
                            <td style="width: 5%"><?php echo CHtml::encode($i + 1); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>
</div>