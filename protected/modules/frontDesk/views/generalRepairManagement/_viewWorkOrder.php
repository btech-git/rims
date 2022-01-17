<div style="height: 350px">
    <h1>Work Order Information</h1>
    <table>
        <tr>
            <td style =" width: 35%">Plate Number: <?php echo $vehicle->plate_number; ?></td>
            <td>Problem : <?php echo $registrationTransaction->problem; ?></td>
        </tr>
        <tr>
            <td>Car Make: <?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Car Model: <?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
            <td>Last Update By: <?php echo $registrationTransaction->user->username; ?></td>
        </tr>
        <tr>
            <td>Work Order #: <?php echo $registrationTransaction->work_order_number; ?></td>
            <td>Status: <?php echo $registrationTransaction->status; ?></td>
        </tr>
        <?php /*if ($registrationTransaction->service_status !== 'Finished'): ?>
            <tr>
                <td>
                    Priority: 
                    <?php echo CHtml::dropDownList('PriorityLevel', $priorityLevel, array(
                         RegistrationTransaction::PRIORITY_HIGH => RegistrationTransaction::PRIORITY_HIGH_LITERAL,
                         RegistrationTransaction::PRIORITY_MEDIUM => RegistrationTransaction::PRIORITY_MEDIUM_LITERAL,
                         RegistrationTransaction::PRIORITY_LOW => RegistrationTransaction::PRIORITY_LOW_LITERAL,
                    )); ?>
                </td>
                <td>
                    Tambah Memo: 
                    <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
                    <?php echo CHtml::submitButton('Submit', array('name' => 'SubmitMemo', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
                </td>
            </tr>
        <?php endif;*/ ?>
    </table>
</div>