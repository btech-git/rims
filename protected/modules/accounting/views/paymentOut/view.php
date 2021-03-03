<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>


<div id="link">
    <?php if (!($paymentOut->status == 'Approved' || $paymentOut->status == 'Rejected')): ?>
        <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/accounting/paymentOut/updateApproval?headerId=' . $paymentOut->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.updateApproval"))) ?>
    <?php endif; ?>
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl.'/accounting/paymentOut/admin' , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"))) ?>
</div>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $paymentOut,
    'attributes' => array(
        array(
            'label' => 'Payment Out #',
            'value' => $paymentOut->payment_number,
        ),
        array(
            'label' => 'Tanggal Payment',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->payment_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $paymentOut->supplier->company,
        ),
        array(
            'label' => 'Code',
            'value' => $paymentOut->supplier->code,
        ),
        array(
            'label' => 'Address',
            'value' => $paymentOut->supplier->address,
        ),
        array(
            'label' => 'Branch',
            'value' => $paymentOut->branch->name,
        ),
        array(
            'label' => 'Payment Type',
            'value' => $paymentOut->paymentType->name,
        ),
        array(
            'label' => 'Giro #',
            'value' => $paymentOut->nomor_giro,
        ),
        array(
            'label' => 'Company Bank',
            'value' => empty($paymentOut->company_bank_id) ? "N/A" : $paymentOut->companyBank->account_name,
        ),
        array(
            'label' => 'Bank',
            'value' => empty($paymentOut->bank_id) ? "N/A" : $paymentOut->bank->name,
        ),
        array(
            'label' => 'Admin',
            'value' => $paymentOut->user->username,
        ),
        array(
            'label' => 'Tanggal Input',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->date_created),
        ),
        array(
            'label' => 'Catatan',
            'value' => $paymentOut->notes,
        ),
    ),
));
?>

<br />

<table style="background-color: greenyellow">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center; width: 10%">Invoice #</th>
            <th style="text-align: center; width: 10%">Tanggal</th>
            <th style="text-align: center; width: 10%">Jatuh Tempo</th>
            <th style="text-align: center">Memo</th>
            <th style="text-align: center; width: 10%">Amount</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($paymentOutDetails as $detail): ?>
            <tr style="background-color: azure">
                <td>
                    <?php $receiveItem = TransactionReceiveItem::model()->findByPk($detail->receive_item_id); ?>
                    <?php echo CHtml::encode($receiveItem->invoice_number); ?>
                </td>
                
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_date'))); ?>
                </td>
                
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($receiveItem, 'invoice_due_date'))); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_invoice'))); ?>
                </td>
            </tr>
	<?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="4">Total Hutang</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'totalInvoice'))); ?>
            </td>
        </tr>
        
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="4">Pembayaran</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'payment_amount'))); ?>
            </td>
        </tr>
    </tfoot>
</table>

<br />

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
            <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $paymentOut->payment_number, 'is_coa_category' => 0)); ?>
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

<br />

<div id="maincontent">
    <div class="clearfix page-action">
        <fieldset>
            <legend>Attached Images</legend>

            <?php foreach ($postImages as $postImage):
                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $postImage->filename;
                $src = Yii::app()->baseUrl . '/images/uploads/paymentOut/' . $postImage->filename;
            ?>
                <div class="row">
                    <div class="small-3 columns">
                        <div style="margin-bottom:.5rem">
                            <?php echo CHtml::image($src, $paymentOut->payment_number . "Image"); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</div>