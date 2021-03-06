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
    <div style="font-size: larger">Laporan Consignment Out</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Consignment Out #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Tanggal Kirim</th>
        <th class="width1-4">Customer</th>
        <th class="width1-5">Admin</th>
        <th class="width1-6">Branch</th>
        <th class="width1-7">Status</th>
    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Quantity Kirim</th>
                    <th class="width2-4">Quantity Sisa</th>
                    <th class="width2-5">Price</th>
                    <th class="width2-6">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($consignmentOutSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->consignment_out_number), array("/transaction/consignmentOut/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date_posting))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->delivery_date))); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php foreach ($header->cashTransactionDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'qty_sent'))); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'qty_request_left'))); ?></td>
                            <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'sale_price'))); ?></td>
                            <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>TOTAL: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_quantity'))); ?></td>
                        <td colspan="4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>