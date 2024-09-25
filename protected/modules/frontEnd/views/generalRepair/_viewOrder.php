<fieldset>
    <!--<legend>Information</legend>-->
    <div class="row">
        <table>
            <tr>
                <td>Assigned Mechanic</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'employeeIdAssignMechanic.name')); ?></td>
                <td>Status Service</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'service_status')); ?></td>
                <td>Sales Order #</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'sales_order_number')); ?></td>
            </tr>
            <tr>
                <td>Insurance Company</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?></td>
                <td>Sales Order Date</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'sales_order_date'))); ?></td>
            </tr>
            <tr>
                <td>Work Order #</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'work_order_number')); ?></td>
                <td>Work Order Date</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'work_order_date'))); ?></td>
            </tr>
            <tr>
                <td>Invoice #</td>
                <td>
                    <?php $invoice = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $model->id)) ?>
                    <?php echo CHtml::encode(CHtml::value($invoice, 'invoice_number')); ?>
                </td>
            </tr>
            <tr>
                <td>User Created</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?></td>
                <td>Date Created</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'created_datetime'))); ?></td>
            </tr>
            <tr>
                <td>User Edited</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?></td>
                <td>Date Edited</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'edited_datetime'))); ?></td>
            </tr>
            <tr>
                <td>User Cancelled</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'userIdCancelled.username')); ?></td>
                <td>Date Cancelled</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy H:m:s", CHtml::value($model, 'cancelled_datetime'))); ?></td>
            </tr>
        </table>
    </div>
</fieldset>