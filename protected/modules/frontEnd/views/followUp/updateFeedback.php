<?php $this->breadcrumbs = array(
    'Material Request'=>array('admin'),
    'Create',
); ?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Feedback Customer</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("adminSales"), array('class' => 'btn btn-info btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<?php echo CHtml::beginForm(); ?>
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Transaction #</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?></td>
                <th>Plat #</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.plate_number')); ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($registrationTransaction, 'transaction_date'))); ?></td>
                <th>Mobil Tipe</th>
                <td>
                    <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carSubModel.name')); ?>
                </td>
            </tr>
            <tr>
                <th>Customer</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.name')); ?></td>
                <th>Mileage (km)</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle_mileage')); ?></td>
            </tr>
            <tr>
                <th>Customer Type</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.customer_type')); ?></td>
                <th>Problem</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'problem')); ?></td>
            </tr>
            <tr>
                <th>Sales Person</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'employeeIdSalesPerson.name')); ?></td>
                <th>Status</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'status')); ?></td>
            </tr>
            <tr>
                <th>Repair Type</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'repair_type')); ?></td>
                <th>Service Status</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'service_status')); ?></td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'payment_status')); ?></td>
                <th>Vehicle Status</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle_status')); ?></td>
            </tr>
            <tr>
                <th>Sales Order #</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'sales_order_number')); ?></td>
                <th>Sales Order Date</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'sales_order_date')); ?></td>
            </tr>
            <tr>
                <th>Work Order #</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_number')); ?></td>
                <th>Work Order date</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_date')); ?></td>
            </tr>
            <tr>
                <th>Invoice #</th>
                <td>
                    <?php $invoice = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id)) ?>
                    <?php echo CHtml::encode(CHtml::value($invoice, 'invoice_number')); ?>
                </td>
                <th>Assigned Mechanic</th>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'employeeIdAssignMechanic.name')); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if (!empty($registrationTransaction->registrationProducts)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Produk</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-info">
                        <th>Code</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Retail Price</th>
                        <th>Sale Price</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrationTransaction->registrationProducts as $i => $product): ?>
                        <tr>
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
                        <td class="text-end" colspan="2">Total Qty</td>
                        <td class="text-center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($registrationTransaction, "total_product"))); ?></td>
                        <td class="text-end" colspan="4">Sub Total Produk</td>
                        <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction, "total_product_price"))); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>

    <?php if (!empty($registrationTransaction->registrationServices)): ?>
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Jasa</legend>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-info">
                        <th>Name</th>
                        <th>Claim</th>
                        <th>Price</th>
                        <th>Discount Type</th>
                        <th>Discount Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrationTransaction->registrationServices as $i => $serviceDetail): ?>
                        <tr>
                            <td><?php echo $service->service->name; ?></td>
                            <td><?php echo $service->claim; ?></td>
                            <td class="text-end"><?php echo number_format($service->price,2); ?></td>
                            <td><?php echo $service->discount_type; ?></td>
                            <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price,2);; ?></td>
                            <td class="text-end"><?php echo number_format($service->total_price,2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-end" colspan="5">Sub Total Jasa</td>
                        <td class="text-end"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction, "total_service_price"))); ?></td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <?php endif; ?>

    <fieldset class="border border-secondary rounded mb-3 p-3">
        <legend class="float-none w-auto text-dark px-1">Customer Feedback</legend>
        <div>
            <?php echo CHtml::activeTextArea($registrationTransaction, 'feedback', array(
                'class' => 'form-control',
                'rows' => 5
            )); ?>
        </div>

        <br /><br />

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </fieldset>
<?php echo CHtml::endForm(); ?>
