<h1>Kelola Data Pembayaran Pembelian</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>New Payment Out', Yii::app()->baseUrl . '/accounting/paymentOut/purchaseOrderList', array(
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

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
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
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-grid',
    'dataProvider' => $dataProvider,
    'filter' => $paymentOut,
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
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierName', $supplierName),
            'value' => 'CHtml::value($data, "supplier.name")',
        ),
        'paymentType.name',
        'notes',
        'branch.name',
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>
