<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs=array(
	'Transaction Purchase Orders'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionPurchaseOrder', 'url'=>array('create')),
);

// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').toggle();
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#transaction-purchase-order-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').slideToggle(600);
		$('.bulk-action').toggle();
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$(this).text('');
		}else {
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
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Purchase Order', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("purchaseOrderCreate"))) ?>
        <h1>Manage Transaction Purchase Orders</h1>
        
        <div class="search-bar">
            <div class="clearfix button-bar">
            <!--<div class="left clearfix bulk-action">
                <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
            </div>-->
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
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
                        'name'=>'supplier_name',
                        'value'=>'empty($data->supplier_id) ? "" : $data->supplier->name',
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
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{edit} {print}',
                        'buttons'=>array (
                            'edit' => array (
                                'label'=>'edit',
                                'url'=>'Yii::app()->createUrl("transaction/transactionPurchaseOrder/update", array("id"=>$data->id))',
                                'visible'=> 'Yii::app()->user->checkAccess("purchaseOrderEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
                            ),
                            'print' => array (
                                'label'=>'print',
                                'url'=>'Yii::app()->createUrl("transaction/transactionPurchaseOrder/pdf", array("id"=>$data->id))',
                                'visible'=> '$data->status_document == "Approved" && Yii::app()->user->checkAccess("purchaseOrderEdit")',
                            ),
                        ),
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