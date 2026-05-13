<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'name',
                'address',
                array('name' => 'province_name', 'value' => $model->province->name),
                array('name' => 'city_name', 'value' => $model->city->name),
                array('name' => 'coa_name', 'value' => $model->coa ? $model->coa->name : ''),
                array('name' => 'coa_code', 'value' => $model->coa ? $model->coa->code : ''),
                'zipcode',
                'phone',
                'mobile_phone',
                'fax',
                'email',
                'note',
                'customer_type',
                'tenor',
                'status',
                'birthdate',
                'flat_rate',
                'date_created',
                'date_approval',
                'status',
                array(
                    'label' => 'Created by',
                    'name' => 'user_id', 
                    'value' => $model->user->username
                ),
            ),
        )); ?>
    </div>
</div>

<div class="row">
    <h5>Vehicles</h5>
    <table class="detail">
        <thead>
            <tr>
                <td>Plat Number</td>
                <td>Kendaraan</td>
                <td>Color</td>
                <td>Year</td>
                <td>Power CC</td>
                <td>Notes</td>
            </tr>
        </thead>
        <?php foreach ($vehicleDetails as $key => $vehicleDetail): ?>
            <tr>
                <td><?php echo CHtml::link($vehicleDetail->plate_number, array("showVehicle", "id" => $vehicleDetail->id), array('target' => '_blank')); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($vehicleDetail, 'carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($vehicleDetail, 'carModel.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($vehicleDetail, 'carSubModel.name')); ?>
                </td>
                <?php $color = Colors::model()->findByPk($vehicleDetail->color_id); ?>
                <td><?php echo empty($color) ? '' : CHtml::encode(CHtml::value($color, 'name')); ?></td>
                <td><?php echo $vehicleDetail->year; ?></td>
                <td><?php echo $vehicleDetail->power; ?></td>
                <td><?php echo $vehicleDetail->notes; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<br/>

<div class="row">
    <h5>Sales History</h5>
    <table class="detail">
        <thead>
            <tr>
                <td>Transaction #</td>
                <td>Date</td>
                <td>Repair</td>
                <td>Car #</td>
                <td>Kendaraan</td>
                <td>Car KM</td>
                <td>Total</td>
            </tr>
        </thead>
        <?php foreach ($invoiceHeaders as $i => $invoiceHeader): ?>
            <?php if ($i < 50): ?>
                <tr>
                    <td><?php echo CHtml::link($invoiceHeader->invoice_number, Yii::app()->createUrl("transaction/invoiceHeader/show", array("id" => $invoiceHeader->id)), array('target' => '_blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_date')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.repair_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carModel.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'registrationTransaction.vehicle_mileage')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoiceHeader, 'total_price'))); ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>

<br />

<div class="row">
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