<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo2.css');
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
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($model, 'transaction_number')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($model, 'transaction_date'))); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; line-height: 0rem">
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
    
<br /><br /><br /><br /><br /><br /><br />

<div id="memonote">
    <table style="width: 98%">
            <?php foreach ($model->invoiceDetails as $i => $detailService): ?>
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
    </table> 
</div>