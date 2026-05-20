<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Product <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'code',
                'manufacturer_code',
                'name',
                'description',
                'production_year',
                array(
                    'name'=>'tire_size_id', 
                    'header' => 'Ukuran Ban',
                    'value'=> CHtml::encode(CHtml::value($model, 'tireSize.tireName')),
                ),
                array(
                    'name'=>'oil_sae_id', 
                    'label' => 'Oli Spesifikasi',
                    'value'=> CHtml::encode(CHtml::value($model, 'oilSae.oilName')),
                ),
                array(
                    'name'=>'unit_id', 
                    'label' => 'Satuan',
                    'value' => CHtml::encode(CHtml::value($model, 'unit.name')),
                ),
                array(
                    'label' => 'Master Category',
                    'name'=>'product_master_category_id', 
                    'value' => CHtml::encode(CHtml::value($model, 'productMasterCategory.name')),
                ),
                array(
                    'label' => 'Sub Master Category',
                    'name'=>'product_sub_master_category_id', 
                    'value' => CHtml::encode(CHtml::value($model, 'productSubMasterCategory.name')),
                ),
                array(
                    'label' => 'Sub Category',
                    'name'=>'product_sub_category_id', 
                    'value' => CHtml::encode(CHtml::value($model, 'productSubCategory.name')),
                ),
                'minimum_stock',
                'date_posting',
                array(
                    'label' => 'Created by',
                    'name' => 'user_id', 
                    'value' => $model->user->username
                ),
                array(
                    'name' => 'user_id_approval',
                    'value' => empty($model->user_id_approval) ? "N/A" : $model->userIdApproval->username,
                ),
                array(
                    'name' => 'date_approval',
                    'value' => empty($model->date_approval) ? "N/A" : $model->date_approval,
                ),
            ),
        )); ?>
    </div>
</div>

<br/>

<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Parts untuk Kendaraan</legend>
            <table>
                <thead>
                    <tr>
                        <th>Merk</th>
                        <th>Model</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->productVehicles as $vehicle): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'vehicleCarMake.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($vehicle, 'vehicleCarModel.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</div>

<br />
    
<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Penjualan</legend>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice #</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>DPP</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoiceDetails as $i => $invoiceDetail): ?>
                        <tr>
                            <td><?php echo CHtml::encode($i+1); ?></td>
                            <td><?php echo CHtml::link($invoiceDetail->invoice->invoice_number, array("/transaction/invoiceHeader/show", "id" => $invoiceDetail->invoice_id), array("target" => "blank")); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, "invoice.invoice_date")); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, "invoice.customer.name")); ?></td>
                            <td style="text-align: center"><?php echo number_format($invoiceDetail->quantity, 0); ?></td>
                            <td style="text-align: right"><?php echo number_format($invoiceDetail->priceAfterDiscount, 2); ?></td>
                            <td style="text-align: right"><?php echo number_format($invoiceDetail->total_price, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>
    </div>
</div>