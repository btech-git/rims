<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>


<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl.'/accounting/workOrderExpense/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"))) ?>
    
    <?php if ($workOrderExpense->status == "Draft" && Yii::app()->user->checkAccess("workOrderExpenseApproval")): ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl.'/accounting/workOrderExpense/updateApproval?headerId=' . $workOrderExpense->id , array('class'=>'button cbutton right','style'=>'margin-right:10px')) ?>
    <?php elseif ($workOrderExpense->status != "Draft" && Yii::app()->user->checkAccess("workOrderExpenseSupervisor")): ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/accounting/workOrderExpense/updateApproval?headerId=' . $workOrderExpense->id , array('class'=>'button cbutton right','style'=>'margin-right:10px')) ?>
    <?php endif; ?>

</div>

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
<br />

<div>
    <?php if (Yii::app()->user->checkAccess("accountingHead")): ?>
        <fieldset>
            <legend>Journal Transactions</legend>
            <table class="report">
                <thead>
                    <tr id="header1">
                        <th style="width: 5%">No</th>
                        <th style="width: 15%">Kode COA</th>
                        <th>Nama COA</th>
                        <th style="width: 15%">Debit</th>
                        <th style="width: 15%">Kredit</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $totalDebit = 0; $totalCredit = 0; ?>
                    <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $workOrderExpense->transaction_number, 'is_coa_category' => 0)); ?>
                    <?php foreach ($transactions as $i => $header): ?>

                        <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                        <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                        <tr>
                            <td style="text-align: center"><?php echo $i + 1; ?></td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                        </tr>

                        <?php $totalDebit += $amountDebit; ?>
                        <?php $totalCredit += $amountCredit; ?>

                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                        <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
                        <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
                    </tr>        
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>
</div>

<br />

<?php //if (Yii::app()->user->checkAccess("accountingHead") && $paymentOut->status === 'Approved' && empty($transactions)): ?>
    <div class="field buttons text-center">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
<?php //endif; ?>