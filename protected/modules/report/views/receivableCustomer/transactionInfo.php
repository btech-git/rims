<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 25% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-7 { width: 10% }
');
?>


<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php //echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="clear"></div>
                <div class="row buttons">
                    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php //echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>
                
                <div style="font-weight: bold; text-align: center">
                    <div style="font-size: larger">Laporan Transaksi Piutang Customer</div>
                    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></div>
                    <div><?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
                </div>

                <br />

                <table class="report">
                    <thead style="position: sticky; top: 0">
                        <tr id="header1">
                            <th class="width1-1">Invoice #</th>
                            <th class="width1-2">Tanggal</th>
                            <th class="width1-3">Jatuh Tempo</th>
                            <th class="width1-4">Plat #</th>
                            <th class="width1-5">Kendaraan</th>
                            <th class="width1-6">Total</th>
                            <th class="width1-7">Payment</th>
                            <th class="width1-8">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalPriceSum = '0.00'; ?>
                        <?php $paymentTotalSum = '0.00'; ?>
                        <?php $paymentLeftSum = '0.00'; ?>
                        <?php foreach ($dataProvider->data as $header): ?>
                            <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
                            <?php $paymentTotal = CHtml::value($header, 'payment_total'); ?>
                            <?php $paymentLeft = CHtml::value($header, 'payment_left'); ?>
                            <tr class="items1">
                                <td>
                                    <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                                        '/transaction/invoiceHeader/show', 
                                        'id' => $header->id, 
                                    ), array('target' => '_blank')); ?>
                                </td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                                </td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentTotal)); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeft)); ?></td>
                            </tr>
                            <?php $totalPriceSum += $totalPrice; ?>
                            <?php $paymentTotalSum += $paymentTotal; ?>
                            <?php $paymentLeftSum += $paymentLeft; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold">Total</td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPriceSum)); ?>
                            </td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentTotalSum)); ?>
                            </td>
                            <td style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeftSum)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="clear"></div>
        </div>
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