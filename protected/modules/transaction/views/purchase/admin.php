<h1>Kelola Data Pembelian Barang</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>
<br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('confirm')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('confirm'); ?>
    </div>
<?php endif; ?>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        Tanggal Mulai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>

        Sampai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>
    </div>

    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('purchase-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>
    <br/>
    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>


</center>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-grid',
    'dataProvider' => $dataProvider,
    'filter' => $purchase,
    'selectableRows' => 1,
    'selectionChanged' => 'function(id){ location.href = "' . $this->createUrl('view') . '/id/"+$.fn.yiiGridView.getSelection(id);}',
    'columns' => array(
        array(
            'name' => 'purchase_order_no',
            'header' => 'Pembelian #',
            'value' => '$data->purchase_order_no',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'purchase_order_date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::encode(CHtml::value($data, "purchase_order_date")))',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'header' => 'Supplier',
            'value' => 'CHtml::encode(CHtml::value($data, "supplier.company"))',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
            'buttons' => array
                (
                'update' => array
                    (
                    'label' => 'Edit',
                ),
            ),
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
));
?>

<?php echo CHtml::endForm(); ?>