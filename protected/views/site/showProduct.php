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
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'sale-grid',
                'dataProvider' => $productSalesDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => 'ID',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registration_transaction_id',
                    ),
                    array(
                        'header' => 'Customer',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->customer->name',
                    ),
                    array(
                        'header' => 'Sales #',
                        'value' => 'empty($data->registration_transaction_id) ? "" : CHtml::link($data->registrationTransaction->transaction_number, array("/frontDesk/registrationTransaction/view", "id" => $data->registration_transaction_id), array("target" => "blank"))',
                        'type'=>'raw'
                    ),
                    array(
                        'header' => 'Tanggal',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->transaction_date',
                    ),
                    array(
                        'header' => 'Quantity',
                        'value' => 'number_format($data->quantity, 0)',
                        'htmlOptions' => array('style' => 'text-align: center'),
                    ),
                    array(
                        'header' => 'DPP',
                        'value' => 'number_format($data->unitPriceBeforeTax, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'header' => 'PPn',
                        'value' => '$data->registrationTransaction->ppnLiteral',
                        'htmlOptions' => array('style' => 'text-align: center'),
                    ),
                    array(
                        'header' => 'Sell Price',
                        'value' => 'number_format($data->unitPriceAfterTax, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'header' => 'Total',
                        'value' => 'number_format($data->total_price, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                ),
            )); ?>
        </fieldset>
    </div>
</div>