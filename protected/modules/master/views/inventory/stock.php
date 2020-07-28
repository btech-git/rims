<?php
Yii::app()->clientScript->registerScript('report', '
        $("#header").addClass("hide");
        $("#mainmenu").addClass("hide");
        $(".breadcrumbs").addClass("hide");
        $("#footer").addClass("hide");
        
        $("#PageSize").val("'.$dataProvider->pagination->pageSize.'");
        $("#CurrentPage").val("'.($dataProvider->pagination->getCurrentPage(false) + 1).'");
            
        .width1-1 { width: 20% }
        .width1-2 { width: 50% }
        .width1-3 { width: 15% }
        .width1-4 { width: 10% }
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/transaction/report.css');
?>

<div class="hide">
    <div class="form" style="text-align: center">
        <?php echo CHtml::beginForm(array(''), 'get'); ?>
            <div class="row" style="background-color: #DFDFDF">
                Nama Produk
                <?php echo CHtml::activeTextField($product, 'name'); ?>
            </div>

            <div class="row button">
                <?php echo CHtml::submitButton('Show', array('onclick'=>'return true;')); ?>
                <?php echo CHtml::resetButton('Clear'); ?>
            </div>
        <?php echo CHtml::endForm(); ?>
    </div>

    <hr />

    <div class="right"><?php echo ReportHelper::summaryText($dataProvider); ?></div>
    <div class="clear"></div>
    <div class="right">
        <?php //echo ReportHelper::sortText($sort, array('Nama Produk')); ?>
    </div>
    <div class="clear"></div>
</div>

<div>
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">Raperind Motor</div>
        <div style="font-size: larger">Laporan Stok Barang</div>
    </div>

    <br />

    <table>
        <tr>
            <th class="width1-2" style="text-align: center">Nama Produk</th>
            <th class="width1-4" style="text-align: center">Master Kategori</th>
            <th class="width1-4" style="text-align: center">Sub Master Kategori</th>
            <th class="width1-4" style="text-align: center">Sub Kategori</th>
            <th class="width1-4" style="text-align: center">R-1</th>
            <th class="width1-4" style="text-align: center">R-4</th>
            <th class="width1-4" style="text-align: center">R-5</th>
            <th class="width1-4" style="text-align: center">R-6</th>
            <th class="width1-4" style="text-align: center">R-8</th>
            <th class="width1-4" style="text-align: center">R-0</th>
            <th class="width1-4" style="text-align: center">R-2</th>
        </tr>
        <?php foreach ($dataProvider->data as $header): ?>
            <tr>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'productMasterCategory.name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'productSubCategory.name')); ?></td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(1))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(2))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(3))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(4))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(5))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(6))); ?>
                </td>
                <td class="width1-4" style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getLocalStock(7))); ?>
                </td>
            </tr>
<!--            <tr class="items2">
                <td colspan="2"></td>
            </tr>-->
        <?php endforeach; ?>
    </table>
</div>