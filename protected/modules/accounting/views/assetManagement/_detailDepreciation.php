<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center">Asset</th>
            <th style="text-align: center; width: 5%">Category</th>
            <th style="text-align: center; width: 10%">Nilai Akumulasi</th>
            <th style="text-align: center; width: 10%">Nilai Sekarang</th>
            <th style="text-align: center; width: 10%">Nilai Depresiasi</th>
            <th style="text-align: center; width: 7%">Bulan ke</th>
            <th style="text-align: center; width: 10%">Periode terakhir</th>
            <th style="text-align: center; width: 13%">Periode sekarang</th>
            <th style="width: 5%"></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($assetDepreciation->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td>
                    <?php $assetPurchase = AssetPurchase::model()->findByPk($detail->asset_purchase_id); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]asset_purchase_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($assetPurchase, 'description')); ?>
                    <?php echo CHtml::error($detail, 'asset_purchase_id'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($detail, 'assetPurchase.assetCategory.code')); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($assetPurchase, 'accumulated_depreciation_value'))); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($assetPurchase, 'current_value'))); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                    <?php echo CHtml::error($detail, 'amount'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]number_of_month"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'number_of_month')); ?>
                    <?php echo CHtml::error($detail, 'number_of_month'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php $depreciationDetail = AssetDepreciationDetail::model()->findByAttributes(array('asset_purchase_id' => $detail->asset_purchase_id)); ?>
                    <?php echo CHtml::encode(CHtml::value($depreciationDetail, 'periodMonthYear')); ?>
                </td>
                
                <td>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]depreciation_period_month", array(
                        '1' => 'Jan',
                        '2' => 'Feb',
                        '3' => 'Mar',
                        '4' => 'Apr',
                        '5' => 'May',
                        '6' => 'Jun',
                        '7' => 'Jul',
                        '8' => 'Aug',
                        '9' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                    <?php echo CHtml::error($detail,'depreciation_period_month'); ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]depreciation_period_year", $detail->yearsRange); ?>
                    <?php echo CHtml::error($detail,'depreciation_period_year'); ?>
                </td>
                
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $assetDepreciation->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
	<?php endforeach; ?>
    </tbody>
</table>
