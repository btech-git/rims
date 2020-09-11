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

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-payment-detail-grid',
    'dataProvider' => new CArrayDataProvider($paymentOut->paymentOutDetails),
    'columns' => array(
        array(
            'header' => 'Invoice #',
            'value' => '$data->receiveItem->invoice_number',
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->receiveItem->invoice_date)',
        ),
        array(
            'header' => 'Jatuh Tempo',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->receiveItem->invoice_due_date)',
        ),
        'memo',
        array(
            'header' => 'Amount',
            'value' => 'number_format($data->total_invoice, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
    ),
));
?>

<table style="background-color: greenyellow">
    <tr>
        <td style="width: 80%; text-align: right; font-weight: bold">Total Hutang</td>
        <td style="width: 20%; text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'totalInvoice'))); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 80%; text-align: right; font-weight: bold">Pembayaran</td>
        <td style="width: 20%; text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentOut, 'payment_amount'))); ?>
        </td>
    </tr>
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