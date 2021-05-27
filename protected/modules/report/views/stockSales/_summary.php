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

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR<?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Inventory Stok Penjualan</div>
        <div>
            <?php //$endDate = date('Y-m-d'); ?>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Product</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Code</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Category</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Brand</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Sub Brand</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Sub Brand Series</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Movement Out Qty</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Sales Qty</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($stockCardSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'subBrandSeries.name')); ?></td>

                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getMovementOutQuantityReport($startDate, $endDate))); ?>
                    </td>
                    
                    <td style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getSalesQuantityReport($startDate, $endDate))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>