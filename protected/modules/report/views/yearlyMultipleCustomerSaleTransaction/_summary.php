<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 3% }
    .width1-3 { width: 25% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">
        Laporan Penjualan Customer Tahunan 
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<fieldset>
    <legend>Company</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Phone</th>
                <th class="width1-5"># of Invoice</th>
                <th class="width1-6">Total Invoice (Rp)</th>
                <th class="width1-7">Total Parts (Rp)</th>
                <th class="width1-8">Total Service (Rp)</th>
                <th class="width1-9">Date 1st Invoice</th>
                <th class="width1-10">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleCustomerCompanySaleReport as $i => $dataItemCompany): ?>
                <?php $invoiceHeader = InvoiceHeader::model()->find(array(
                    'condition' => 't.customer_id = :customer_id AND t.user_id_cancelled IS NULL', 
                    'params' => array(':customer_id' => $dataItemCompany['customer_id']),
                    'order' => 't.invoice_date ASC',
                )); ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_id']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($dataItemCompany['customer_name']), array(
                            'transactionInfo', 
                            'customerId' => $dataItemCompany['customer_id'], 
                            'branchId' => $branchId,
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItemCompany['customer_phone']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($dataItemCompany['invoice_quantity']), array(
                            'transactionInfo', 
                            'customerId' => $dataItemCompany['customer_id'], 
                            'branchId' => $branchId,
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['grand_total'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['total_product'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemCompany['total_service'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($invoiceHeader, 'invoice_date')))); ?>
                    </td>
                    <td style="text-align: center">
                        <?php $startSeconds = strtotime($invoiceHeader->invoice_date); ?>
                        <?php $endSeconds = strtotime($endDate); ?> 
                        <?php $secondsDiff = $endSeconds - $startSeconds; ?>
                        <?php $daysDiff = round($secondsDiff / (60 * 60 * 24)); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $daysDiff)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Individual</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Phone</th>
                <th class="width1-5"># of Invoice</th>
                <th class="width1-6">Total Invoice (Rp)</th>
                <th class="width1-7">Total Parts (Rp)</th>
                <th class="width1-8">Total Service (Rp)</th>
                <th class="width1-9">Date 1st Invoice</th>
                <th class="width1-10">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleCustomerIndividualSaleReport as $i => $dataItemIndividual): ?>
                <?php $invoiceHeader = InvoiceHeader::model()->find(array(
                    'condition' => 't.customer_id = :customer_id AND t.user_id_cancelled IS NULL', 
                    'params' => array(':customer_id' => $dataItemIndividual['customer_id']),
                    'order' => 't.invoice_date ASC',
                )); ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_id']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($dataItemIndividual['customer_name']), array(
                            'transactionInfo', 
                            'customerId' => $dataItemIndividual['customer_id'], 
                            'branchId' => $branchId,
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItemIndividual['customer_phone']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($dataItemIndividual['invoice_quantity']), array(
                            'transactionInfo', 
                            'customerId' => $dataItemIndividual['customer_id'], 
                            'branchId' => $branchId,
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['grand_total'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['total_product'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItemIndividual['total_service'])); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($invoiceHeader, 'invoice_date')))); ?>
                    </td>
                    <td style="text-align: center">
                        <?php $startSeconds = strtotime($invoiceHeader->invoice_date); ?>
                        <?php $endSeconds = strtotime($endDate); ?> 
                        <?php $secondsDiff = $endSeconds - $startSeconds; ?>
                        <?php $daysDiff = round($secondsDiff / (60 * 60 * 24)); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $daysDiff)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>