<div id="maincontent">
        <h1>View Vehicle <?php echo $model->plate_number; ?></h1>

        <div class="row">
            <div class="small-12 columns">
                <?php $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'plate_number',
                        'machine_number',
                        'frame_number',
                        array(
                            'name' => 'car_make', 
                            'value' => $model->carMake->name
                        ),
                        array(
                            'name' => 'car_model', 
                            'value' => $model->carModel->name
                        ),
                        array(
                            'name' => 'car_sub_model', 
                            'value' => $model->carSubModel->name
                        ),
                        array(
                            'label' => 'Color', 
                            'value' => empty($model->color_id) ? '' : $model->color->name,
                        ),
                        'year',
                        'chasis.name: Chassis',
                        array(
                            'name' => 'customer_id', 
                            'value' => CHtml::encode(CHtml::value($model, 'customer.name')),
                        ),
                        'customer.address',
                        'customer.mobile_phone',
                        'customer.email',
                        'customer.note',
                        'status_location',
                        'notes',
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>

<hr />
                
<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Transaction History</legend>
            <div class="grid-view">
                <table>
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Tanggal</th>
                            <th>Registration #</th>
                            <th>Repair Type</th>
                            <th>KM Sebelum</th>
                            <th>KM Service</th>
                            <th>KM Selanjutnya</th>
                            <th>Problem</th>
                            <th>Rekomendasi Service</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($invoiceHeaders as $invoiceHeader): ?>
                            <tr>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_date')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.transaction_number')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.repair_type')); ?></td>
                                <td><?php echo number_format(CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.previous_mileage')), 0); ?></td>
                                <td><?php echo number_format(CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.vehicle_mileage')), 0); ?></td>
                                <td><?php echo number_format(CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.next_mileage')), 0); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.problem')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.next_service_recommendation')); ?></td>
                                <td style="text-align: right">
                                    <?php echo number_format(CHtml::encode(CHtml::value($invoiceHeader, 'total_price')), 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
        
        <br />
        
        <fieldset>
            <legend>Service History</legend>
            <div class="grid-view">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Service</th>
                            <th>Type</th>
                            <th>Kategori</th>
                            <th>Price</th>
                            <th>Invoice #</th>
                            <th>Tanggal</th>
                            <th>Repair Type</th>
                            <th>KM</th>
                            <th>Problem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($invoiceHeaders as $invoiceHeader): ?>
                            <?php $invoiceDetails = InvoiceDetail::model()->findAll(array(
                                'condition' => 'invoice_id = :invoice_id AND service_id IS NOT NULL AND product_id IS NULL',
                                'params' => array(':invoice_id' => $invoiceHeader->id),
                            )); ?>
                            <?php foreach($invoiceDetails as $invoiceDetail): ?>
                                <tr>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'service_id')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'service.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'service.serviceType.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'service.serviceCategory.name')); ?></td>
                                    <td style="text-align: right">
                                        <?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'total_price')), 2); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_date')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.repair_type')); ?></td>
                                    <td><?php echo number_format(CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.vehicle_mileage')), 0); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.problem')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
        
        <br />
        
        <fieldset>
            <legend>Parts History</legend>
            <div class="grid-view">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Parts</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Ukuran</th>
                            <th>SAE</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Invoice #</th>
                            <th>Tanggal</th>
                            <th>Repair Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($invoiceHeaders as $invoiceHeader): ?>
                            <?php $invoiceDetails = InvoiceDetail::model()->findAll(array(
                                'condition' => 'invoice_id = :invoice_id AND product_id IS NOT NULL AND service_id IS NULL',
                                'params' => array(':invoice_id' => $invoiceHeader->id),
                            )); ?>
                            <?php foreach($invoiceDetails as $invoiceDetail): ?>
                                <tr>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product_id')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.manufacturer_code')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.name')); ?></td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.brand.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.subBrand.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.subBrandSeries.name')); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.productMasterCategory.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.productSubMasterCategory.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.productSubCategory.name')); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.tireSize.tireName')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'product.oilSae.oilName')); ?></td>
                                    <td style="text-align: center">
                                        <?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'quantity')), 0); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'unit_price')), 2); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'discount')), 2); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'total_price')), 2); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_date')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.repair_type')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>