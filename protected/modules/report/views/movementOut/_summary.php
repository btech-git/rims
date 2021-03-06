<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Movement Out</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Movement #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Delivery #</th>
        <th class="width1-4">Return #</th>
        <th class="width1-5">Registration #</th>
        <th class="width1-6">Material Request #</th>
        <th class="width1-7">Status</th>
        <th class="width1-8">Type</th>
        <th class="width1-9">Admin</th>
        <th class="width1-10">Branch</th>
    </tr>
    <tr id="header2">
        <td colspan="10">
            <table>
                <tr>
                    <th class="width2-1">Product</th>
                    <th class="width2-2">Quantity</th>
                    <th class="width2-3">Quantity Transaction</th>
                    <th class="width2-4">Warehouse</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($movementOutSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->movement_out_no), array("/transaction/movementOut/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date_posting))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'deliveryOrder.delivery_order_no')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'returnOrder.return_order_no')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'materialRequest.transaction_number')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode($header->status); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'movementTypeChar')); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="10">
                <table>
                    <?php foreach ($header->movementOutDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                            <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_transaction'))); ?></td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'warehouse.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>TOTAL: </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'totalQuantity'))); ?></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>