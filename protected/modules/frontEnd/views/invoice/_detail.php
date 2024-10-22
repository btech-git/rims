<?php if (count($invoice->details) != 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-secondary">
                <th>Product / Service</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Price</th>
            </thead>
            <tbody>
                <?php foreach ($invoice->details as $i => $detail): ?>
                    <tr>
                        <td>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]service_id"); ?>
                            <?php echo CHtml::activeHiddenField($detail, "[$i]quick_service_id"); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'quickService.name')); ?>
                        </td>
                        <td class="text-center">
                            <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                            <?php echo number_format($detail->quantity, 0); ?>
                        </td>
                        <td class="text-end">
                            <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                            <?php echo number_format($detail->unit_price, 2); ?>
                        </td>
                        <td class="text-end">
                            <?php echo CHtml::activeHiddenField($detail, "[$i]total_price"); ?>
                            <?php echo number_format($detail->total_price, 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
<!--                <tr>
                    <td class="text-end" colspan="3">Total Quick Service</td>
                    <td class="text-end"><?php //echo number_format(CHtml::encode(CHtml::value($invoice->header, 'quick_service_price')), 2); ?></td>
                </tr>-->
                <tr>
                    <td class="text-end fw-bold" colspan="3">Total Jasa</td>
                    <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'service_price')), 2); ?></td>
                </tr>
                <tr>
                    <td class="text-end fw-bold" colspan="3">Total Produk</td>
                    <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'product_price')), 2); ?></td>
                </tr>
                <tr>
                    <td class="text-end fw-bold" colspan="3">Sub Total</td>
                    <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'subtotal')), 2); ?></td>
                </tr>
                <tr>
                    <td class="text-end fw-bold" colspan="3">Ppn</td>
                    <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'ppn_total')), 2); ?></td>
                </tr>
                <tr>
                    <td class="text-end fw-bold" colspan="3">Grand Total</td>
                    <td class="text-end fw-bold"><?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'total_price')), 2); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endif; ?>