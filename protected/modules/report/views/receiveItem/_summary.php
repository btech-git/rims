<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Receive Item</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Receive #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Tanggal Tiba</th>
        <th class="width1-4">Type</th>
        <th class="width1-5">Supplier</th>
        <th class="width1-6">Branch</th>
        <th class="width1-7">Penerima</th>
    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Quantity Request</th>
                    <th class="width2-3">Quantity Received</th>
                    <th class="width2-4">Memo</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($receiveItemSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->receive_item_no), array("/transaction/transactionReceiveItem/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->receive_item_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->arrival_date))); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(($header->request_type)); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'recipientBranch.name')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php foreach ($header->transactionReceiveItemDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'qty_request'))); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'qty_received'))); ?></td>
                            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>