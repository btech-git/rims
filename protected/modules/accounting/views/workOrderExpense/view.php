<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>


<div id="link">
    <?php //if (!($workOrderExpense->status == 'Approved' || $workOrderExpense->status == 'Rejected')): ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/accounting/workOrderExpense/updateApproval?headerId=' . $workOrderExpense->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.updateApproval"))) ?>
    <?php //endif; ?>
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl.'/accounting/workOrderExpense/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"))) ?>
</div>

<h1>View Sub Pekerjaan Luar <?php echo $this->id . '/' . $this->action->id; ?></h1>

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
            'label' => 'WO $',
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