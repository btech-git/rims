<h1>List Registration Service</h1>
   
<div id="link">
    <?php echo CHtml::link('Management', array('admin'), array('class'=>'button success')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'registration-transaction-grid',
    'dataProvider' => $registrationTransactionDataProvider,
    'filter' => $registrationTransaction,
    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'transaction_number',
            'header' => 'RG #',
            'value' => '$data->transaction_number',
        ),
        array(
            'name' => 'work_order_number',
            'header' => 'WO #',
            'value' => '$data->work_order_number',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'transaction_date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->transaction_date)',
        ),
        array(
            'name' => 'branch_id',
            'header' => 'Cabang',
            'filter' => CHtml::activeDropDownList($registrationTransaction, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->branch->name',
        ),
        'repair_type',
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerName', $customerName, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "customer.name")',
        ),
        array(
            'header' => 'Plate #',
            'filter' => CHtml::textField('VehicleNumber', $vehicleNumber),
            'value' => 'CHtml::value($data, "vehicle.plate_number")',
        ),
        array(
            'header' => 'Asuransi',
            'name' => 'insurance_company_id',
            'filter' => CHtml::activeDropDownList($registrationTransaction, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => 'CHtml::encode(CHtml::value($data, "insuranceCompany.name"))',
        ),
        'note',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "registrationTransactionId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>