<?php $this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
); ?>


<div id="link">
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
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $paymentOut->payment_date),
        ),
        array(
            'label' => 'Status',
            'value' => $paymentOut->status,
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
            'label' => 'Bank',
            'value' => empty($paymentOut->bank_id) ? "" : $paymentOut->bank->name,
        ),
        array(
            'label' => 'Catatan',
            'value' => $paymentOut->notes,
        ),
    ),
));
?>

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
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'invoice_grand_total'))); ?>
                </td>
            </tr>
	<?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="4">Total Hutang</td>
            <td style="text-align: right; font-weight: bold">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'totalInvoice'))); ?>
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