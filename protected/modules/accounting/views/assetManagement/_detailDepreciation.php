<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center">Asset</th>
            <th style="text-align: center; width: 15%">Category</th>
            <th style="text-align: center; width: 15%">Nilai Akumulasi</th>
            <th style="text-align: center; width: 15%">Nilai Sekarang</th>
            <th style="text-align: center; width: 15%">Nilai Depresiasi</th>
            <th style="text-align: center; width: 10%">Bulan ke</th>
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
                
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'assetPurchase.assetCategory.description')); ?>
                </td>
                
                <td>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($assetPurchase, 'accumulated_depreciation_value'))); ?>
                </td>
                
                <td>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($assetPurchase, 'current_value'))); ?>
                </td>
                
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]amount"); ?>
                    <?php echo CHtml::error($detail, 'amount'); ?>
                </td>
                
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]number_of_month"); ?>
                    <?php echo CHtml::error($detail, 'number_of_month'); ?>
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
