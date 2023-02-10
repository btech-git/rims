<h1>List Supplier</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment Out', Yii::app()->baseUrl.'/accounting/paymentOut/admin' , array(
        'class'=>'button cbutton',
        'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"),
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'supplier-grid',
    'dataProvider' => $supplierDataProvider,
    'filter' => $supplier,
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
            'value' => 'CHtml::link("Create", array("create", "supplierId" => $data->id, "movementType" => 1))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>