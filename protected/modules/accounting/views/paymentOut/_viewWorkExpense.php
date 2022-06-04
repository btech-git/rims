<h2>Invoice Upah</h2>

<hr />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'work-order-expense-grid',
        'dataProvider'=>$workOrderExpenseDataProvider,
        'filter'=>$workOrderExpense,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'transaction_number', 
                'header' => 'Invoice #',
                'value'=>'CHtml::link($data->transaction_number, array("/accounting/workOrderExpense/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date', 
                'header' => 'Tanggal',
                'value'=>'$data->transaction_date',
            ),
            array(
                'header'=>'WO #', 
                'value'=>'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->work_order_number', 
            ),
            array(
                'header' => 'Customer',
                'value' => 'CHtml::value($data, "registrationTransaction.customer.name")',
            ),
            array(
                'header' => 'Plate #',
                'value' => 'CHtml::value($data, "registrationTransaction.vehicle.plate_number")',
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createSingle", "transactionId"=>$data->id, "movementType"=>"2"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>