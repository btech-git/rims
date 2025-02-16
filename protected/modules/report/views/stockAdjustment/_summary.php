<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 5% }
    .width1-7 { width: 20% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 20% }
    .width2-4 { width: 5% }
    .width2-5 { width: 5% }
    .width2-6 { width: 5% }
    .width2-7 { width: 5% }
    .width2-8 { width: 5% }
    .width2-9 { width: 5% }
    .width2-10 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Penyesuaian Stok Gudang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Penyesuaian #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Tipe</th>
            <th class="width1-4">Cabang</th>
            <th class="width1-5">Tujuan</th>
            <th class="width1-6">Status</th>
            <th class="width1-7">Catatan</th>
            <th class="width1-8">Pembuat</th>
            <th class="width1-9">Supervisor</th>
            <th class="width1-10">Tanggal Input</th>
        </tr>
        <tr id="header2">
            <td colspan="10">
                <table>
                    <tr>
                        <th class="width2-1" rowspan="2">Code</th>
                        <th class="width2-2" rowspan="2">Name</th>
                        <th class="width2-3" rowspan="2">Brand</th>
                        <th colspan="3">Gudang</th>
                        <th colspan="3">Gudang Tujuan</th>
                        <th class="width2-10" rowspan="2">Memo</th>
                    </tr>
                    <tr>
                        <th class="width2-4">Stok</th>
                        <th class="width2-5">Penyesuaian</th>
                        <th class="width2-6">Selisih</th>
                        <th class="width2-7" rowspan="2">Stok</th>
                        <th class="width2-8" rowspan="2">Penyesuaian</th>
                        <th class="width2-9" rowspan="2">Selisih</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($stockAdjustmentSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1">
                    <?php echo CHtml::link($header->stock_adjustment_number, Yii::app()->createUrl("frontDesk/adjustment/view", array("id" => $header->id)), array('target' => '_blank')); ?>
                </td>
                <td class="width1-2">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date_posting))); ?>
                </td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchIdDestination.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'supervisor.username')); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy H:m:s', strtotime($header->created_datetime))); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="10">
                    <table>
                        <?php foreach ($header->stockAdjustmentDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                                <td class="width2-3">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> - 
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> - 
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                                </td>
                                <td class="width2-4" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity_current)); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity_adjustment)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantityDifference)); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity_current_destination)); ?>
                                </td>
                                <td class="width2-8" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity_adjustment_destination)); ?>
                                </td>
                                <td class="width2-9" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantityDifferenceDestination)); ?>
                                </td>
                                <td class="width2-10" style="text-align: right">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>