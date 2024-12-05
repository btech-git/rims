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
    $('#work-order-expense-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<h1>Kelola Data Sub Pekerjaan Luar</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span> Sub Pekerjaan Luar', Yii::app()->baseUrl . '/accounting/workOrderExpense/create', array(
        'class' => 'button success right',
//        'visible' => Yii::app()->user->checkAccess("transaction.paymentOut.create")
    )); ?>
</div>

<br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
<center>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('work-order-expense-grid',{data:{pageSize:$(this).val()}});",
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
    'id' => 'work-order-expense-grid',
    'dataProvider' => $dataProvider,
    'filter' => null,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
       'cssFile'=>false,
       'header'=>'',
    ),
    'columns' => array(
        array(
            'name' => 'transaction_number',
            'header' => 'Sub Pekerjaan Luar #',
            'value'=>'CHtml::link($data->transaction_number, array("/accounting/workOrderExpense/view", "id"=>$data->id), array("target" => "blank"))', 
            'type'=>'raw',
        ),
        array(
            'header' => 'Tanggal Transaksi',
            'name' => 'transaction_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
        ),
        array(
            'header' => 'WO #',
            'value'=>'CHtml::link($data->registrationTransaction->work_order_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->registration_transaction_id), array("target" => "blank"))', 
            'type'=>'raw',
        ),
        array(
            'header' => 'Repair Type',
            'value' => 'CHtml::value($data, "registrationTransaction.repair_type")',
        ),
        array(
            'header' => 'Customer',
            'value' => 'CHtml::value($data, "registrationTransaction.customer.name")',
        ),
        array(
            'header' => 'Plate #',
            'value' => 'CHtml::value($data, "registrationTransaction.vehicle.plate_number")',
        ),
//        array(
//            'header' => 'Branch',
//            'value' => 'CHtml::value($data, "branch.code")',
//        ),
        array(
            'name' => 'note',
            'value' => 'substr(CHtml::value($data, "note"), 0, 30)',
        ),
        array(
            'header' => 'Created By',
            'name' => 'user_id',
            'filter' => false,
            'value' => 'empty($data->user_id) ? "N/A" : $data->user->username '
        ),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'buttons' => array(
//                'edit' => array(
//                    'label' => 'update',
//                    'url' => 'Yii::app()->createUrl("accounting/workOrderExpense/update", array("id"=>$data->id))',
//                    'visible' => 'Yii::app()->user->checkAccess("workOrderExpenseEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
//                ),
                'view' => array(
                    'label' => 'view',
                    'url' => 'Yii::app()->createUrl("accounting/workOrderExpense/view", array("id"=>$data->id))',
                ),
            ),
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>
