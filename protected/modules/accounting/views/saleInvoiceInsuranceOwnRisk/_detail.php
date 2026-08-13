<fieldset>
    <legend>Parts</legend>
    <table style="border: 1px solid">
        <thead>
            <tr style="background-color: skyblue">
                <th style="text-align: center; width: 3%">No.</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Parts</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Category</th>
                <th style="text-align: center">Quantity</th>
                <th style="text-align: center">Satuan</th>
            </tr>
        </thead>

        <tbody>
            <?php $totalQuantity = '0.00'; ?>
            <?php foreach ($registrationTransaction->registrationProducts as $i => $detailProduct): ?>
                <?php $quantity = CHtml::value($detailProduct, 'quantity'); ?>
                <tr style="background-color: azure">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.subBrandSeries.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.productMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.productSubMasterCategory.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($detailProduct, 'product.productSubCategory.name')); ?>
                    </td>
                    <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailProduct, 'product.unit.name')); ?></td>
                </tr>
                <?php $totalQuantity += $quantity; ?>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr style="background-color: aquamarine">
                <td colspan="5" style="text-align: right; font-weight: bold">Total:</td>
                <td style="text-align: center; font-weight: bold">
                    <span id="grand_total">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalQuantity)); ?>
                        </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Jasa</legend>
    <table style="border: 1px solid">
        <thead>
            <tr style="background-color: skyblue">
                <th style="text-align: center; width: 3%">No.</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Jasa</th>
                <th style="text-align: center">Tipe</th>
                <th style="text-align: center">Kategori</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($registrationTransaction->registrationServices as $i => $detailService): ?>
                <tr style="background-color: azure">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailService, 'service.code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailService, 'service.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailService, 'service.serviceType.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detailService, 'service.serviceCategory.name')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>