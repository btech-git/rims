<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 3% }
    .width1-3 { width: 20% }
    .width1-4 { width: 15% }
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
        Laporan Penjualan Asuransi Tahunan 
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<fieldset>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">No</th>
                <th class="width1-2">ID</th>
                <th class="width1-3">Name</th>
                <th class="width1-4">Akun</th>
                <th class="width1-5"># of Invoice</th>
                <th class="width1-6">Total Invoice (Rp)</th>
                <th class="width1-7">Total Parts (Rp)</th>
                <th class="width1-8">Total Service (Rp)</th>
                <th class="width1-9">Date 1st Invoice</th>
                <th class="width1-10">Duration from 1st Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yearlyMultipleInsuranceSaleReport as $i => $dataItemCompany): ?>
                <?php $invoiceHeader = InvoiceHeader::model()->find(array(
                    'condition' => 't.insurance_company_id = :insurance_company_id AND t.user_id_cancelled IS NULL', 
                    'params' => array(':insurance_company_id' => $dataItemCompany['insurance_company_id']),
                    'order' => 't.invoice_date ASC',
                )); ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode($dataItemCompany['insurance_company_id']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($dataItemCompany['insurance_name']), array(
                            'transactionInfo', 
                            'insuranceId' => $dataItemCompany['insurance_company_id'], 
                            'branchId' => $branchId,
                            'startDate' => $startDate, 
                            'endDate' => $endDate
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItemCompany['coa_name']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode($dataItemCompany['invoice_quantity']), array(
                            'transactionInfo', 
                            'insuranceId' => $dataItemCompany['insurance_company_id'], 
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