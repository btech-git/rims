<h1>List Customer</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment In', Yii::app()->baseUrl.'/transaction/paymentIn/admin' , array(
        'class'=>'button cbutton',
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $customerDataProvider,
    'filter' => $customer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'company',
            'value' => '$data->company',
        ),
        array(
            'name' => 'name',
            'value' => '$data->name',
        ),
        array(
            'name' => 'code',
            'value' => '$data->code',
        ),
        'tenor',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("CreateMultiple", array("create", "customerId" => $data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>