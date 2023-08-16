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
        'visible' => Yii::app()->user->checkAccess("paymentOutCreate")
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
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                )); ?>
            </div><!-- search-form -->
        </div>
    </div>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'payment-out-grid',
    'dataProvider' => $dataProvider,
    'filter' => null,
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
            'header' => 'Tanggal Bayar',
            'name' => 'payment_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date)'
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierName', $supplierName),
            'value' => 'CHtml::value($data, "supplier.name")',
        ),
        array(
            'name' => 'payment_amount', 
            'value' => 'number_format($data->payment_amount, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        array(
            'header' => 'Created By',
            'name' => 'user_id',
            'filter' => false,
            'value' => 'empty($data->user_id) ? "N/A" : $data->user->username '
        ),
        array(
            'header' => 'Approved By',
            'value' => 'empty($data->paymentOutApprovals) ? "N/A" : $data->paymentOutApprovals[0]->supervisor->username '
        ),
        array(
            'header' => 'Approval Status',
            'value' => 'empty($data->paymentOutApprovals) ? "N/A" : $data->getApprovalStatus()'
        ),
        array(
            'header' => 'Tanggal Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->created_datetime)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}',
            'buttons' => array(
                'update' => array(
                    'label' => 'update',
                    'url' => 'Yii::app()->createUrl("accounting/paymentOut/update", array("id"=>$data->id))',
                    'visible' => 'Yii::app()->user->checkAccess("paymentOutEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
                ),
                'view' => array(
                    'label' => 'view',
                    'url' => 'Yii::app()->createUrl("accounting/paymentOut/view", array("id"=>$data->id))',
                ),
            ),
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php //echo CHtml::endForm(); ?>

<hr />

<fieldset>
    <legend>Pending Payment</legend>
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Hutang Supplier' => array(
                    'content' => $this->renderPartial('_viewReceivable', array(
                        'receiveItem' => $receiveItem,
                        'receiveItemDataProvider' => $receiveItemDataProvider,
                    ), true)
                ),
                'Biaya Sub Pekerjaan' => array(
                    'content' => $this->renderPartial('_viewWorkExpense', array(
                        'workOrderExpense' => $workOrderExpense,
                        'workOrderExpenseDataProvider' => $workOrderExpenseDataProvider,
                    ), true)
                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_tab',
        )); ?>
    </div>
</fieldset>
