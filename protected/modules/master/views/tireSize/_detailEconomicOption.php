<table>
    <thead>
        <tr>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th style="width: 3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tireSize->economicOptionDetails as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]sub_brand_series_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "subBrandSeries.subBrand.brand.name")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "subBrandSeries.subBrand.name")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "subBrandSeries.name")); ?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemovePremiumOptionDetail', array('id' => $tireSize->header->id, 'index' => $i)),
                            'update' => '#premium_option_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
