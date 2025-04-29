<div class="large-12 columns">
    <fieldset>
        <legend>Product Sales</legend>
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
                    'value' => 'empty($data->registration_transaction_id) ? "" : CHtml::link($data->registrationTransaction->transaction_number, array("/frontDesk/generalRepairRegistration/view", "id" => $data->registration_transaction_id), array("target" => "blank"))',
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