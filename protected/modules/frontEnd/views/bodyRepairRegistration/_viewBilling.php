<fieldset>
    <!--<legend>Billing</legend>-->
    <?php if (count($products) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Product name</th>
                    <th>Quantity</th>
                    <th>Retail Price</th>
                    <th>Sale Price</th>
                    <th>Disc Type</th>
                    <th>Disc</th>
                    <th>Total Price</th>
                    <th>Qty Movement</th>
                    <th>Qty Movement left</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $i => $product): ?>
                    <tr>
                        <td><?php echo $product->product->id; ?></td>
                        <td><?php echo $product->product->manufacturer_code; ?></td>
                        <td><?php echo $product->product->name; ?></td>
                        <td><?php echo $product->quantity; ?></td>
                        <td><?php echo number_format($product->retail_price,2); ?></td>
                        <td><?php echo number_format($product->sale_price,2); ?></td>
                        <td><?php echo $product->discount_type; ?></td>
                        <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                        <td><?php echo number_format($product->total_price,2); ?></td>
                        <td><?php echo $product->quantity_movement; ?></td>
                        <td><?php echo $product->quantity_movement_left; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total Quantity</td>
                    <td><?php echo number_format($model->total_product, 0); ?></td>
                    <td>Discount</td>
                    <td><?php echo number_format($model->discount_product, 2); ?></td>
                </tr>
                <tr>
                    <td>Sub Total</td>
                    <td><?php echo number_format($model->total_product_price, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
    <br /><hr />
    <?php if (count($services) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Service name</th>
                    <th>Claim</th>
                    <th>Price</th>
                    <th>Discount Type</th>
                    <th>Discount Price</th>
                    <th>Total Price</th>
                    <th>Hour</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $i => $service): ?>
                    <tr>
                        <td><?php echo $service->service->name; ?></td>
                        <td><?php echo $service->claim; ?></td>
                        <td><?php echo number_format($service->price, 2); ?></td>
                        <td><?php echo $service->discount_type; ?></td>
                        <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price, 2); ?></td>
                        <td><?php echo number_format($service->total_price, 2); ?></td>
                        <td><?php echo $service->hour; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total Quantity</td>
                    <td><?php echo number_format($model->total_service, 0); ?></td>
                    <td>Discount</td>
                    <td><?php echo number_format($model->discount_service, 2); ?></td>
                </tr>
                <tr>
                    <td>Sub Total</td>
                    <td><?php echo number_format($model->total_service_price, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <table>
        <tr>
            <td>PPN Price</td>
            <td><?php echo number_format($model->ppn_price, 2); ?></td>
        </tr>
        <tr>
            <td>PPH Price</td>
            <td><?php echo number_format($model->pph_price, 2); ?></td>
        </tr>
        <tr>
            <td>Grand Total</td>
            <td><?php echo number_format($model->grand_total, 2); ?></td>
        </tr>
    </table>
</fieldset>