<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 8% }
    .width1-3 { width: 15% }
    .width1-4 { width: 7% }
    .width1-5 { width: 5% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 5% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Sent Request</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Sent Request #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Status</th>
        <th class="width1-4">Tanggal Tiba</th>
        <th class="width1-5">Tujuan</th>
        <th class="width1-6">Approved By</th>
        <th class="width1-7">User Request</th>
    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">Parts</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Satuan</th>
                    <th class="width2-4">Unit Price</th>
                    <th class="width2-5">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($sentRequestSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1">
                <?php echo CHtml::link(CHtml::encode($header->sent_request_no), array(
                    "/transaction/transactionSentRequest/view", 
                    "id"=>$header->id
                ), array("target" => "_blank")); ?>
            </td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->sent_request_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(($header->status_document)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->estimate_arrival_date))); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'destinationBranch.code')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'approval.username')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php foreach ($header->transactionSentRequestDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?>
                            </td>
                            <td class="width2-5" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold">TOTAL</td>
                        <td style="text-align: center; font-weight: bold">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_quantity'))); ?>
                        </td>
                        <td colspan="2">&nbsp;</td>
                        <td style="text-align: right; font-weight: bold">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>