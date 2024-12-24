<?php $materialRequestDetails = $model->materialRequestDetails; ?>
<?php if (count($materialRequestDetails) > 0): ?>
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
                <td>Satuan Permintaan</td>
                <td>Satuan Inventory</td>
                <td>COA</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialRequestDetails as $key => $materialRequestDetail): ?>
                <?php $product = empty($materialRequestDetail->product_id) ? '' : $materialRequestDetail->product; ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td><?php echo $product->name; ?></td>
                    <td><?php echo $product->manufacturer_code; ?></td>
                    <td><?php echo $product->masterSubCategoryCode; ?></td>
                    <td><?php echo $product->brand->name; ?></td>
                    <td><?php echo $product->subBrand->name; ?></td>
                    <td><?php echo $product->subBrandSeries->name; ?></td>
                    <td style="text-align: center"><?php echo $materialRequestDetail->quantity; ?></td>
                    <td><?php echo $materialRequestDetail->unit->name; ?></td>
                    <td><?php echo $materialRequestDetail->product->unit->name; ?></td>
                    <td><?php echo $product->productSubMasterCategory->coaPersediaanBarangDagang->name; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right; font-weight: bold">Total</td>
                <td style="text-align: center; font-weight: bold"><?php echo $model->totalQuantity; ?></td>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>