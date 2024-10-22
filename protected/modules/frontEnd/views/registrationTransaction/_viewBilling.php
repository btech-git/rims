<fieldset>
    <?php if (count($products) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-primary">
                    <th>ID</th>
                    <th>Code</th>
                    <th>Product name</th>
                    <th>Quantity</th>
                    <th>Retail Price</th>
                    <th>Sale Price</th>
                    <th>Disc Type</th>
                    <th>Disc</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $i => $product): ?>
                    <tr class="table-light">
                        <td><?php echo $product->product->id; ?></td>
                        <td><?php echo $product->product->manufacturer_code; ?></td>
                        <td><?php echo $product->product->name; ?></td>
                        <td class="text-center"><?php echo $product->quantity; ?></td>
                        <td class="text-end"><?php echo number_format($product->retail_price,2); ?></td>
                        <td class="text-end"><?php echo number_format($product->sale_price,2); ?></td>
                        <td><?php echo $product->discount_type; ?></td>
                        <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                        <td class="text-end"><?php echo number_format($product->total_price,2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-end" colspan="3">Total Quantity</td>
                    <td class="text-center"><?php echo number_format($model->total_product, 0); ?></td>
                    <td class="text-end" colspan="4">Total Produk</td>
                    <td class="text-end"><?php echo number_format($model->total_product_price, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
    
    <br /><hr />
    
    <?php if (count($services) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="table-primary">
                    <th>Service name</th>
                    <th>Claim</th>
                    <th>Hour</th>
                    <th>Price</th>
                    <th>Discount Type</th>
                    <th>Discount Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $i => $service): ?>
                    <tr class="table-light">
                        <td><?php echo $service->service->name; ?></td>
                        <td><?php echo $service->claim; ?></td>
                        <td><?php echo $service->hour; ?></td>
                        <td class="text-end"><?php echo number_format($service->price, 2); ?></td>
                        <td><?php echo $service->discount_type; ?></td>
                        <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price, 2); ?></td>
                        <td class="text-end"><?php echo number_format($service->total_price, 2); ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-end" colspan="6">Total Jasa</td>
                    <td class="text-end"><?php echo number_format($model->total_service_price, 2); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <table class="table table-bordered table-bordered">
        <tr>
            <td class="text-end">Sub Total</td>
            <td class="text-end"><?php echo number_format($model->subtotal, 2); ?></td>
        </tr>
        <tr>
            <td class="text-end">PPN Price</td>
            <td class="text-end"><?php echo number_format($model->ppn_price, 2); ?></td>
        </tr>
        <tr>
            <td class="text-end">PPH Price</td>
            <td class="text-end"><?php echo number_format($model->pph_price, 2); ?></td>
        </tr>
        <tr>
            <td class="text-end">Grand Total</td>
            <td class="text-end"><?php echo number_format($model->grand_total, 2); ?></td>
        </tr>
    </table>
</fieldset>