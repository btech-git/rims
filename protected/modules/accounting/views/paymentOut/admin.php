<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Out' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    
    return false;
});
$('.search-form form').submit(function(){
    $('#payment-out-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<h1>Kelola Data Pembayaran Pembelian</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>New Payment Out', Yii::app()->baseUrl . '/accounting/paymentOut/supplierList', array(
        'class' => 'button success right',
        'visible' => Yii::app()->user->checkAccess("transaction.paymentOut.create")
    )); ?>
</div>

<br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<?php //echo CHtml::beginForm(array(''), 'get'); ?>
<center>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('payment-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    
    <div class="search-bar">
        <div class="clearfix button-bar">
            <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $paymentOut,
                )); ?>
            </div><!-- search-form -->
        </div>
    </div>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-out-grid',
    'dataProvider' => $dataProvider,
    'filter' => $paymentOut,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
       'cssFile'=>false,
       'header'=>'',
    ),
    'columns' => array(
        array(
            'name' => 'payment_number',
            'header' => 'Pembayaran #',
            'value' => '$data->payment_number',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'payment_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date)'
        ),
        array(
            'header' => 'PO #',
            'name' => 'purchase_order_number',
            'filter' => false,
            'value' => 'empty($data->purchase_order_id) ? "N/A" : $data->purchaseOrder->purchase_order_no '
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierName', $supplierName),
            'value' => 'CHtml::value($data, "supplier.name")',
        ),
        'paymentType.name: Payment Type',
        array(
            'name' => 'payment_amount', 
            'value' => 'number_format($data->payment_amount, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        'notes',
        'branch.name: Branch',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}',
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php //echo CHtml::endForm(); ?>

<hr />

<h1>List Hutang Supplier</h1>

<br />

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receive-item-grid',
    'dataProvider' => $receiveItemDataProvider,
    'filter' => $receiveItem,
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'header' => 'PO #',
            'value' => '$data->purchaseOrder->purchase_order_no',
        ),
        array(
            'name' => 'invoice_number',
            'header' => 'Invoice #',
            'value' => '$data->invoice_number',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'invoice_date',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)'
        ),
        array(
            'name' => 'supplier_name',
            'header' => 'Supplier',
            'value' => '$data->supplier->name',
        ),
        array(
            'name' => 'supplier_delivery_number',
            'header' => 'Supplier SJ #',
            'value' => '$data->supplier_delivery_number',
        ),
        array(
            'header' => 'Jatuh Tempo',
            'name' => 'invoice_due_date',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_due_date)'
        ),
        array(
            'header' => 'Total',
            'filter' => false,
            'value' => 'number_format(CHtml::value($data, "invoice_grand_total"), 2)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'user_id_invoice',
            'filter' => false,
            'header' => 'Admin',
            'value' => 'empty($data->user_id_invoice) ? "N/A" : $data->userIdInvoice->username',
        ),
        array(
            'header' => 'Tanggal Input',
            'value' => '$data->dateTimeCreated',
        ),
    ),
)); ?>
