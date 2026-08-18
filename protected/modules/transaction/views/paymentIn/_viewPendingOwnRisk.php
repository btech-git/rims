<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'own-risk-grid',
        // 'dataProvider'=>$vehicleDataProvider,
        'dataProvider' => $invoiceOwnRiskDataProvider,
        'filter' => $saleInvoiceInsuranceOwnRisk,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name' => 'transaction_number',
                'value' => 'CHtml::link($data->transaction_number, array("/accounting/saleInvoiceInsuranceOwnRisk/show", "id"=>$data->id), array("target" => "_blank"))',
                'type' => 'raw'
            ),
            array(
                'name' => 'transaction_date',
                'header' => 'Tanggal',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)',
            ),
            array(
                'header' => 'Umur (hari)', 
                'value' => '$data->outstandingDays',
                'htmlOptions' => array('style' => 'text-align: center'),
            ),
            array(
                'name' => 'customer_id',
                'value' => 'CHtml::encode(CHtml::value($data, "customer.name"))',
            ),
            array(
                'name' => 'insurance_company_id',
                'value' => 'CHtml::encode(CHtml::value($data, "insuranceCompany.name"))',
            ),
            array(
                'name' => 'vehicle_id',
                'value' => 'CHtml::encode(CHtml::value($data, "vehicle.carMakeModelSubCombination"))',
            ),
            'vehicle.plate_number',
            array(
                'name' => 'amount_invoice', 
                'value' => 'AppHelper::formatMoney($data->amount_invoice)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createInvoiceOwnRisk", "invoiceOwnRiskId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>