<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        // 'dataProvider'=>$vehicleDataProvider,
        'dataProvider' => $invoiceDataProvider,
        'filter' => $invoice,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name' => 'invoice_number',
                'value' => 'CHTml::link($data->invoice_number, array("saleInvoice/view", "id"=>$data->id))',
                'type' => 'raw'
            ),
            array(
                'name' => 'invoice_date',
                'header' => 'Tanggal',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)',
            ),
            array(
                'name' => 'due_date',
                'header' => 'Jatuh Tempo',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->due_date)',
            ),
            array(
                'header' => 'Umur (hari)', 
                'value' => '$data->remainingDueDate',
                'htmlOptions' => array('style' => 'text-align: center'),
            ),
            array(
                'name' => 'customer_id', 
                'filter' => CHtml::activeDropDownList($invoice, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                    'condition' => 'id IN (60849, 60926, 63482)',
                    'order' => 'name'
                )), 'id', 'name'), array('empty' => '-- all --')),
                'value' => '$data->customer->name'
            ),
            array(
                'header' => 'Plate #', 
                'filter' => CHtml::textField('PlateNumberInvoice', $plateNumberInvoice),
                'value' => 'empty($data->vehicle_id) ? "N/A" : $data->vehicle->plate_number'
            ),
            'status',
//            array(
//                'header' => 'Insurance',
//                'filter' => CHtml::activeDropDownList($invoice, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --')),
//                'value' => 'empty($data->insurance_company_id) ? "N/A" : $data->insuranceCompany->name',
//            ),
//            array(
//                'name' => 'user_id',
//                'filter' => CHtml::activeDropDownList($invoice, 'user_id', CHtml::listData(Users::model()->findAll(array('order' => 'username')), 'id', 'username'), array('empty' => '-- all --')),
//                'header' => 'Created By',
//                'value' => 'empty($data->user_id) ? "N/A" : $data->user->username',
//            ),
            array(
                'name' => 'total_price', 
                'value' => 'AppHelper::formatMoney($data->total_price)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_amount', 
                'value' => 'AppHelper::formatMoney($data->payment_amount)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_left', 
                'value' => 'AppHelper::formatMoney($data->payment_left)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "invoiceId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>