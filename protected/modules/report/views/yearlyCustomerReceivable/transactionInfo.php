<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 25% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
');
?>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">Laporan Piutang Customer <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></div>
        <div><?php echo $monthList[$month] . ' ' . $year; ?></div>
    </div>
    
    <br /> 
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Invoice #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Plat #</th>
                    <th class="width1-4">Vehicle</th>
                    <th class="width1-5">Status</th>
                    <th class="width1-6">Total</th>
                    <th class="width1-7">Payment</th>
                    <th class="width1-8">Remaining</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalPriceSum = '0.00'; ?>
                <?php $totalPaymentSum = '0.00'; ?>
                <?php $totalRemainingSum = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                    <?php $paymentAmount = CHtml::value($header, 'payment_amount'); ?>
                    <?php $paymentLeft = CHtml::value($header, 'payment_left'); ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                        </td>
                    </tr>
                    <?php $totalPriceSum += $totalPrice; ?>
                    <?php $totalPaymentSum += $paymentAmount; ?>
                    <?php $totalRemainingSum += $paymentLeft; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPriceSum)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentSum)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemainingSum)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>