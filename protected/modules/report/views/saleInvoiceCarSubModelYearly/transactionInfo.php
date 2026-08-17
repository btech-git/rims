<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 25% }
    .width1-4 { width: 8% }
    .width1-5 { width: 15% }
    .width1-6 { width: 15% }
    .width1-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></div>
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div style="font-size: large">
        <?php echo CHtml::encode(CHtml::value($carSubModel, 'carMake.name')); ?>
        <?php echo CHtml::encode(CHtml::value($carSubModel, 'carModel.name')); ?>
        <?php echo CHtml::encode(CHtml::value($carSubModel, 'name')); ?>
    </div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th style="width: 3%">No</th>
                    <th class="width1-1">Invoice #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Customer</th>
                    <th class="width1-4">Plat #</th>
                    <th class="width1-5">Parts</th>
                    <th class="width1-6">Service</th>
                    <th class="width1-7">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalQuantity = 0; ?>
                <?php $totalPriceSum = '0.00'; ?>
                <?php foreach ($dataProvider->data as $i => $header): ?>
                        <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                        <tr class="items1">
                            <td style="text-align:center"><?php echo ++$i; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'productLists')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'serviceLists')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                            </td>
                        </tr>
                        <?php $totalPriceSum += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="font-weight:bold; text-align: right">TOTAL</td>
                    <td>&nbsp;</td>
                    <td style="font-weight:bold; text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPriceSum)); ?>
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