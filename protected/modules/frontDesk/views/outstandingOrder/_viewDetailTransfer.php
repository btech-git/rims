<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Qty Request</th>
            <th>Qty Delivery</th>
            <th>Unit Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transferRequestDetails as $key => $transferRequestDetail): ?>
            <tr>
                <?php $product = Product::model()->findByPK($transferRequestDetail->product_id); ?>
                <td><?php echo $product->name; ?></td>
                <td><?php echo $product->brand->name; ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                <td><?php echo $product->masterSubCategoryCode; ?></td>
                <td><?php echo $transferRequestDetail->unit->name; ?></td>
                <td><?php echo $transferRequestDetail->quantity; ?></td>
                <td><?php echo $transferRequestDetail->quantity_delivery; ?></td>
                <td style="text-align: right"><?php echo AppHelper::formatMoney($transferRequestDetail->unit_price); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
