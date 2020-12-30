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
    <div style="font-size: larger">Laporan Purchase Order</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Purchase #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Status</th>
        <th class="width1-4">Type</th>
        <th class="width1-5">Supplier</th>
        <th class="width1-6">Approved By</th>
        <th class="width1-7">Branch</th>
        <th class="width1-8">Admin</th>
    </tr>
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Retail Price</th>
                    <th class="width2-4">Unit Price</th>
                    <th class="width2-5">Total Quantity</th>
                    <th class="width2-6">Discount</th>
                    <th class="width2-7">Total Price</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($purchaseOrderSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->purchase_order_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(($header->status_document)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode($header->getPurchaseStatus($header->purchase_type)); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'approval.username')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'mainBranch.name')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php foreach ($header->transactionPurchaseOrderDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'retail_price'))); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                            <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_quantity'))); ?></td>
                            <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'discount'))); ?></td>
                            <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td style="text-align: right">TOTAL QUANTITY: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_quantity'))); ?></td>
                        <td style="text-align: right" colspan="4">SUB TOTAL: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'subtotal'))); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right" colspan="6">PPN: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'ppn_price'))); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right" colspan="6">GRAND TOTAL: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>