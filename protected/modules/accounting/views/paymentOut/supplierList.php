<h1>List Supplier</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment Out', Yii::app()->baseUrl.'/accounting/paymentOut/admin' , array(
        'class'=>'button cbutton',
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
        array(
            'header' => 'TOP (hari)',
            'name' => 'tenor',
            'value' => '$data->tenor',
        ),
        array(
            'header' => 'PO',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "supplierId" => $data->id, "movementType" => 1))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
        array(
            'header' => 'Sub Pekerjaan',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "supplierId" => $data->id, "movementType" => 2))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
//        array(
//            'header' => 'Pembelian non stok',
//            'type' => 'raw',
//            'value' => 'CHtml::link("Create", array("create", "supplierId" => $data->id, "movementType" => 3))',
//            'htmlOptions' => array(
//                'style' => 'text-align: center;'
//            ),
//        ),
    ),
)); ?>