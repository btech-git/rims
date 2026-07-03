<?php
$this->breadcrumbs=array(
	'Purchase Orders'=>array('admin'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').slideToggle(600);
        $('.bulk-action').toggle();
        $(this).toggleClass('active');
        
        if ($(this).hasClass('active')){
            $(this).text('');
        } else {
            $(this).text('Advanced Search');
        }
        
        return false;
    });
    $('.search-form form').submit(function(){
        $('#transaction-purchase-order-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
");
?>

	
<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("purchaseOrderCreate"))) ?>
        <h1>Manage Transaction Purchase Orders</h1>
        
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'supplier' => $supplier,
                        'supplierDataProvider' => $supplierDataProvider,
                    )); ?>
                </div><!-- search-form -->				
            </div>
         </div>

         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'transaction-purchase-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'columns'=>array(
                    array(
                        'name'=>'purchase_order_no', 
                        'value'=>'CHTml::link($data->purchase_order_no, array("view", "id"=>$data->id))', 
                        'type'=>'raw'
                    ),
                    'purchase_order_date',
                    array(
                        'name'=>'purchase_type',
                        'filter' => CHtml::activeDropDownList($model, 'purchase_type', array(
                            TransactionPurchaseOrder::SPAREPART => TransactionPurchaseOrder::SPAREPART_LITERAL,
                            TransactionPurchaseOrder::TIRE => TransactionPurchaseOrder::TIRE_LITERAL,
                            TransactionPurchaseOrder::GENERAL => TransactionPurchaseOrder::GENERAL_LITERAL,
                        ), array('empty' => '-- All --')),
                        'value'=>'$data->getPurchaseStatus($data->purchase_type)',
                    ),
                    array(
                        'name'=>'supplier_id',
                        'value'=>'empty($data->supplier_id) ? "" : $data->supplier->company',
                    ),
                    array(
                        'name' => 'total_price',
                        'filter' => false,
                        'value' => 'number_format($data->total_price, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    'status_document',
                    array(
                        'name' => 'requester_id',
                        'header' => 'Created By',
                        'filter' => false,
                        'value' => '$data->user->username',
                    ),
                    array(
                        'name' => 'approved_id',
                        'header' => 'Approved By',
                        'filter' => false,
                        'value' => 'empty($data->approval) ? "" : $data->approval->username',
                    ),
                    array(
                        'header' => 'Status Receive',
                        'value' => '$data->totalRemainingQuantityReceived',
                    ),
                    'payment_status',
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>