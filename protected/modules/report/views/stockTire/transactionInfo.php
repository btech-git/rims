<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 7% }
    .width1-3 { width: 10% }
    .width1-4 { width: 30% }
    .width1-5 { width: 7% }
    .width1-6 { width: 7% }
    .width1-7 { width: 7% }
    .width1-8 { width: 7% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Stok Ban <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></div>
    <div style="font-size: larger">
        <?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?> - 
        <?php echo CHtml::encode(CHtml::value($product, 'name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($product, 'tireSize.tireName')); ?>
    </div>
    <div>DOT: <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead">
        <div class="reportDisplay" style="text-align: right">
            <?php echo ReportHelper::summaryText($dataProvider); ?>
        </div>
    </div>
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Transaction #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Type</th>
                    <th class="width1-4">Note</th>
                    <th class="width1-5">Beginning</th>
                    <th class="width1-6">In</th>
                    <th class="width1-7">Out</th>
                    <th class="width1-8">Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php $beginningStock = 0; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $stockIn = CHtml::value($header, 'stock_in'); ?>
                    <?php $stockOut = CHtml::value($header, 'stock_out'); ?>
                    <tr class="items1">
                        <td>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($header, 'transaction_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $header->id)), array('target' => '_blank')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $beginningStock)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stockIn)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $stockOut)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php $endingStock = $beginningStock + $stockIn + $stockOut; ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $endingStock)); ?>
                        </td>
                    </tr>
                    <?php $beginningStock = $endingStock; ?>
                <?php endforeach; ?>
            </tbody>
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