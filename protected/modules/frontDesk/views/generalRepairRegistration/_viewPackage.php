<table>
    <thead>
        <tr>
            <th>Paket</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Quantity</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($packages as $key => $package): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($package, 'salePackageHeader.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($package, 'salePackageHeader.start_date')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($package, 'salePackageHeader.end_date')); ?></td>
                <td><?php echo number_format($package->quantity, 0); ?></td>
                <td><?php echo number_format($package->price, 2); ?></td>
                <td><?php echo number_format($package->total_price, 2); ?></td>
            </tr>
            <tr>
                <td colspan="6">
                    <table>
                        <?php foreach($package->salePackageHeader->salePackageDetails as $detail): ?>
                            <tr>
                                <td>
                                    <?php if (empty($detail->product_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?>
                                    <?php else: ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo number_format($package->quantity, 0); ?></td>
                                <td>
                                    <?php if (empty($detail->product_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'service.unit.name')); ?>
                                    <?php else: ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>