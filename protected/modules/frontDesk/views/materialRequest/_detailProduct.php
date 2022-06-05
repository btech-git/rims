<h2>Product List</h2>

<br />

<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="width: 5%">No.</th>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Sub Category</th>
            <th>Detail Category</th>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th>Quantity</th>
            <th>Satuan</th>
        </tr>
    </thead>

    <?php if (!empty($materialRequest->header->registration_transaction_id)): ?>
        <tbody>
            <?php foreach ($materialRequest->header->registrationTransaction->registrationProducts as $i => $detail): ?>
                <tr>
                    <?php $product = $detail->product; ?>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'productSubCategory.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'quantity'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name'));  ?></td>
                </tr>	
            <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>