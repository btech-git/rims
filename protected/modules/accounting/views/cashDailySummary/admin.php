<h1>Kelola Data Kas Harian</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>Kas Harian Approval', Yii::app()->baseUrl . '/accounting/cashDailySummary/summary', array(
        'class' => 'button success right',
        'visible' => Yii::app()->user->checkAccess("accounting.cashDaily.report")
    )); ?>
</div>

<br /><br /><br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php /*
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('payment-grid',{data:{pageSize:$(this).val()}});",
        )
    );*/
    ?>

<!--    <div class="page-size-wrap">
        <span>Display by:</span><?php //echo $pageSizeDropDown; ?>
    </div>-->
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cash-daily-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'Tanggal',
            'name' => 'transaction_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
        ),
        'paymentType.name: Payment Type',
        array(
            'name' => 'amount', 
            'value' => 'number_format($data->amount, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right'         
            ),
        ),
        'memo',
        'branch.name: Branch',
        array(
            'header' => 'Approved By',
            'value' => 'CHtml::value($data, "user.username")',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>