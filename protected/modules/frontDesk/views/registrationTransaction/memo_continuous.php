<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#utilities").addClass("hide");
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
    addEventListener("afterprint", function() {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxJsonPrintCounter', array('id' => $invoiceHeader->id)).'",
        });
    });
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 50% }
    .sig3 { width: 25% }
    
    .memo-title
    {
        margin-left:35%;
        font-size:9px;
    }
');
?>

<div id="memoheader">
    <div class="memo-logo">&nbsp;</div>
    <div class="memo-title">
        <table style="background-color: white;">
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($invoiceHeader, 'invoice_date'))); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'customer.name')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.plate_number')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem">
                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carSubModel.name')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
    
<br /><br /><br /><br /><br /><br /><br />

<div id="memonote">
    <table style="width: 98%">
        <?php if (count($services) > 0): ?>
            <?php foreach ($services as $i => $detailService): ?>
                <tr class="titems">
                    <td style="text-align: left; line-height: 0rem; width: 15%"><?php echo CHtml::encode(CHtml::value($detailService, 'service.code')); ?></td>
                    <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($detailService, 'service.name')); ?></td>
                    <td style="text-align: center; line-height: 0rem; width: 10%">1</td>
                    <td style="text-align: right; line-height: 0rem; width: 15%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailService, 'price'))); ?>
                    </td>

                    <td style="text-align: right; line-height: 0rem; width: 17%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailService, 'total_price'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $i => $detailProduct): ?>
                <tr class="titems">
                    <td style="text-align: left; line-height: 0rem; width: 15%"><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.manufacturer_code')); ?></td>
                    <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.name')); ?></td>
                    <td style="text-align: center; line-height: 0rem; width: 10%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProduct, 'quantity'))); ?>
                    </td>
                    <td style="text-align: right; line-height: 0rem; width: 15%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProduct, 'sale_price'))); ?>
                    </td>

                    <td style="text-align: right; line-height: 0rem; width: 17%">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProduct, 'total_price'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
                
        <tr>
            <td style="text-align: right; line-height: 0rem" colspan="4">Total :</td>

            <td style="text-align: right; line-height: 0rem; width: 17%">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoiceHeader, 'total_price'))); ?>
            </td>
        </tr>
    </table> 
    
    <div style="text-transform: capitalize">
        TERBILANG:
        <?php echo CHtml::encode(NumberWord::numberName(CHtml::value($invoiceHeader, 'total_price'))); ?>
        rupiah
    </div>

</div>