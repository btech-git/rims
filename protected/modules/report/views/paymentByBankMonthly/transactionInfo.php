<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 25% }
    .width1-4 { width: 25% }
    .width1-5 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Bank Bulanan</div>
    <div style="font-size: larger">
        <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?> - 
        <?php echo CHtml::encode(CHtml::value($coa, 'name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($coa, 'coaCategory.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($coa, 'coaSubCategory.name')); ?>
    </div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($date))); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Transaksi #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Note</th>
                    <th class="width1-4">Memo</th>
                    <th class="width1-5">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalSum = '0.00'; ?>
                <?php foreach ($dataProvider->data as $header): ?>
                    <?php $totalAmount = CHtml::value($header, 'total'); ?>
                    <tr class="items1">
                        <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'kode_transaksi')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'debet_kredit')); ?></td>
                        <td class="width1-5" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?>
                        </td>
                    </tr>
                    <?php $totalSum += $totalAmount; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right">TOTAL</td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSum)); ?>
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