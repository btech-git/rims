<?php $materialRequestDetails = $model->materialRequestDetails; ?>
<?php if (count($materialRequestDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Quantity</td>
                <td>Unit</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialRequestDetails as $key => $materialRequestDetail): ?>
                <?php $product = empty($materialRequestDetail->product_id) ? '' : $materialRequestDetail->product; ?>
                <tr>
                    <td><?php echo $product->name; ?></td>
                    <td><?php echo $product->manufacturer_code; ?></td>
                    <td><?php echo $product->masterSubCategoryCode; ?></td>
                    <td><?php echo $product->brand->name; ?></td>
                    <td><?php echo $product->subBrand->name; ?></td>
                    <td><?php echo $product->subBrandSeries->name; ?></td>
                    <td style="text-align: center"><?php echo $materialRequestDetail->quantity; ?></td>
                    <td><?php echo $product->unit->name; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold">Total</td>
                <td style="text-align: center; font-weight: bold"><?php echo $model->totalQuantity; ?></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>