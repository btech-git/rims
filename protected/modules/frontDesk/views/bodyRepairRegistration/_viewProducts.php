<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Product name</th>
            <th>Quantity</th>
            <th>Satuan</th>
            <?php if (Yii::app()->user->checkAccess('director')): ?>
                <th>HPP</th>
            <?php endif; ?>
            <th>Retail Price</th>
            <th>Sale Price</th>
            <th>Discount Type</th>
            <th>Discount</th>
            <th>Total Price</th>
            <th>Quantity Movement</th>
            <th>Quantity Movement left</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $i => $product): ?>
                <tr>
                    <td><?php echo $product->product_id; ?></td>
                    <td><?php echo $product->product->manufacturer_code; ?></td>
                    <td><?php echo $product->product->name; ?></td>
                    <td><?php echo $product->quantity; ?></td>
                    <td><?php echo $product->unit->name; ?></td>
                    <?php if (Yii::app()->user->checkAccess('director')): ?>
                        <td><?php echo number_format($product->hpp,2); ?></td>
                    <?php endif; ?>
                    <td><?php echo number_format($product->retail_price,2); ?></td>
                    <td><?php echo number_format($product->sale_price,2); ?></td>
                    <td><?php echo $product->discount_type; ?></td>
                    <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                    <td><?php echo number_format($product->total_price,2); ?></td>
                    <td><?php echo $product->quantity_movement; ?></td>
                    <td><?php echo $product->quantity_movement_left; ?></td>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
