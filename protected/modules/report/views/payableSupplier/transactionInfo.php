<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 25% }
    .width1-4 { width: 25% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
');
?>


<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">Transaksi Detail Hutang Supplier</div>
        <div style="font-size: larger; font-weight: bold; text-align: center"><?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></div>
        <div style="font-size: larger; font-weight: bold; text-align: center">
            <?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>
    
    <div class="clear"></div>
    
    <?php echo CHtml::beginForm('', 'get'); ?>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelDetail')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

    <br /> 
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>
                
                <br />

                <table class="report">
                    <thead style="position: sticky; top: 0">
                        <tr id="header1">
                            <th class="width1-1">Transaksi #</th>
                            <th class="width1-2">Tanggal</th>
                            <th class="width1-3">Keterangan</th>
                            <th class="width1-4">Note</th>
                            <th class="width1-5">Invoice</th>
                            <th class="width1-6">Pembayaran</th>
                            <th class="width1-7">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalDebit = '0.00'; ?>
                        <?php $totalCredit = '0.00'; ?>
                        <?php //$totalBalance = '0.00'; ?>
                        <?php $balanceAmount = '0.00'; ?> 
                        
                        <?php foreach ($dataProvider->data as $header): ?>
                            <?php if ($header->debet_kredit == 'D'): ?>
                                <?php $amountDebit = $header->total; ?>
                                <?php $amountCredit = '0.00'; ?>
                            <?php else: ?>
                                <?php $amountDebit = '0.00'; ?>
                                <?php $amountCredit = $header->total; ?>
                            <?php endif; ?>
                            <?php $balanceAmount += $amountDebit - $amountCredit; ?>

                            <tr class="items2">
                                <td><?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("report/payableSupplier/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                                <td><?php echo CHtml::encode($header->remark); ?></td>
                                <td><?php echo CHtml::encode($header->transaction_subject); ?></td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $balanceAmount)); ?>
                                </td>
                            </tr>
                            <?php $totalDebit += $amountDebit; ?>
                            <?php $totalCredit += $amountCredit; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="font-weight: bold; text-align: right">Total</td>
                            <td style="font-weight: bold; text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                            </td>
                            <td style="font-weight: bold; text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                            </td>
                            <td style="font-weight: bold; text-align: right">
                                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalBalance)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
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