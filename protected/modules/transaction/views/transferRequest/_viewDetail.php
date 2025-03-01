<?php if (count($transferDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Quantity</td>
                <td>Unit</td>
                <td>Memo</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transferDetails as $key => $transferDetail): ?>
                <tr>
                    <td><?php echo $transferDetail->product ? CHtml::link($transferDetail->product_id, array("/master/product/view", "id"=>$transferDetail->product_id), array('target' => 'blank')) : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? $transferDetail->product->name : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? $transferDetail->product->manufacturer_code : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? $transferDetail->product->masterSubCategoryCode : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? CHtml::encode(CHtml::value($transferDetail, 'product.brand.name')) : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? CHtml::encode(CHtml::value($transferDetail, 'product.subBrand.name')) : '-'; ?></td>
                    <td><?php echo $transferDetail->product ? CHtml::encode(CHtml::value($transferDetail, 'product.subBrandSeries.name')) : '-'; ?></td>
                    <td style="text-align: center"><?php echo $transferDetail->quantity; ?></td>
                    <td><?php echo $transferDetail->unit->name; ?></td>
                    <td><?php echo $transferDetail->memo; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right; font-weight: bold">Total Quantity</td>
                <td style="text-align: center; font-weight: bold"><?php echo $model->total_quantity; ?></td>
                <td colspan="2">&nbsp;</td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>