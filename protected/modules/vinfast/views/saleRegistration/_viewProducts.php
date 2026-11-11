<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Satuan</th>
            <?php if (Yii::app()->user->checkAccess('director')): ?>
                <th>HPP</th>
            <?php endif; ?>
            <th>Retail Price</th>
            <th>Sale Price</th>
            <th>Disc Type</th>
            <th>Disc</th>
            <th>Total Price</th>
            <th>Qty Movement</th>
            <th>Qty Movement left</th>
            <th></th>
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
                    <td><?php echo CHtml::encode(CHtml::value($product, 'product.unit.name')); ?></td>
                    <?php if (Yii::app()->user->checkAccess('director')): ?>
                        <td><?php echo number_format($product->product->hpp,2); ?></td>
                    <?php endif; ?>
                    <td><?php echo number_format($product->retail_price,2); ?></td>
                    <td><?php echo number_format($product->sale_price,2); ?></td>
                    <td><?php echo $product->discount_type; ?></td>
                    <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                    <td><?php echo number_format($product->total_price,2); ?></td>
                    <td><?php echo $product->quantity_movement; ?></td>
                    <td><?php echo $product->quantity_movement_left; ?></td>
                    <td>
                        <?php $technicalReport = TechnicalReportHeader::model()->findByAttributes(array(
                            'registration_product_id' => $product->id,
                        )); ?>
                        <?php if (!empty($model->warranty_report) && empty($technicalReport)): ?>
                            <?php echo CHtml::link('Tech Report', array('technicalReport/create', 'registrationProductId' => $product->id), array(
                                'class' => 'button info left', 
                                'style' => 'margin-right:10px', 
                            )); ?>
                        <?php elseif (!empty($model->warranty_report && $technicalReport)): ?>
                            <?php echo CHtml::link('Tech Report', array('technicalReport/view', 'id' => $technicalReport->id)); ?>
                        <?php else: ?>
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif ?>
    </tbody>
</table>