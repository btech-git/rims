<h1>List Purchase Order</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment Out', Yii::app()->baseUrl.'/accounting/paymentOut/admin' , array(
        'class'=>'button cbutton',
        'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.admin"),
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-order-grid',
    'dataProvider' => $purchaseOrderDataProvider,
    'filter' => $purchaseOrder,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'purchase_order_no',
            'header' => 'PO #',
            'value' => '$data->purchase_order_no',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'purchase_order_date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMM yy", $data->purchase_order_date)',
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierName', $supplierName, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "supplier.name")',
        ),
        array(
            'header' => 'Grand Total',
            'name' => 'total_price',
            'filter' => false, 
            'value' => 'number_format($data->total_price, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => 'Pembayaran',
            'name' => 'payment_amount',
            'filter' => false, 
            'value' => 'number_format($data->payment_amount, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => 'Sisa',
            'name' => 'payment_left',
            'filter' => false, 
            'value' => 'number_format($data->payment_left, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "purchaseOrderId" => $data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>