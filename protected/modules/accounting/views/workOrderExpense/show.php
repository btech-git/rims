<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>

<h1>View Sub Pekerjaan Luar <?php //echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $workOrderExpense,
    'attributes' => array(
        array(
            'label' => 'Upah Invoice #',
            'value' => $workOrderExpense->transaction_number,
        ),
        array(
            'label' => 'Tanggal Invoice',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $workOrderExpense->transaction_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $workOrderExpense->supplier->name,
        ),
        array(
            'label' => 'WO #',
            'value' => $workOrderExpense->registrationTransaction->work_order_number,
        ),
        array(
            'label' => 'Customer',
            'value' => $workOrderExpense->registrationTransaction->customer->name,
        ),
        array(
            'label' => 'Plate #',
            'value' => $workOrderExpense->registrationTransaction->vehicle->plate_number,
        ),
        array(
            'label' => 'Branch',
            'value' => $workOrderExpense->branch->name,
        ),
        array(
            'label' => 'Admin',
            'value' => $workOrderExpense->user->username,
        ),
        array(
            'label' => 'Catatan',
            'value' => $workOrderExpense->note,
        ),
        array(
            'label' => 'Status',
            'value' => $workOrderExpense->status,
        ),
    ),
));
?>

<br />

<div>
    <h2>Service List</h2>

    <br />

    <table style="border: 1px solid">
        <thead>
            <tr style="background-color: skyblue">
                <th style="width: 5%">No.</th>
                <th>Service</th>
                <th style="width: 25%">Type</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>

        <?php if (!empty($workOrderExpense->registrationTransaction)): ?>
            <tbody>
                <?php foreach ($workOrderExpense->registrationTransaction->registrationServices as $i => $detail): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name'));  ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name'));  ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'status'));  ?></td>
                    </tr>	
                <?php endforeach; ?>
            </tbody>
        <?php endif; ?>
    </table>
</div>
<br />

<div>
    <table style="background-color: greenyellow">
        <thead>
            <tr style="background-color: skyblue">
                <th style="text-align: center">Description</th>
                <th style="text-align: center">Memo</th>
                <th style="text-align: center; width: 15%">Amount</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($workOrderExpenseDetails as $detail): ?>
                <tr style="background-color: azure">
                    <td><?php echo CHtml::encode($detail->description); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td style="text-align: right; font-weight: bold" colspan="2">Total</td>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($workOrderExpense, 'totalDetail'))); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>