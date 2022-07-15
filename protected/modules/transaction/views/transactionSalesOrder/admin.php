<?php
/* @var $this TransactionSalesOrderController */
/* @var $model TransactionSalesOrder */

$this->breadcrumbs = array(
    'Transaction Sales Orders' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionSalesOrder', 'url' => array('admin')),
    array('label' => 'Create TransactionSalesOrder', 'url' => array('create')),
);

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
	$('#transaction-sales-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Sales Order',
            Yii::app()->baseUrl . '/transaction/transactionSalesOrder/create', array(
                'class' => 'button success right',
                'visible' => Yii::app()->user->checkAccess("saleOrderCreate")
            )); ?>
        <h1>Manage Transaction Sales Orders</h1>
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
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                    )); ?>
                </div><!-- search-form -->
            </div>
        </div>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'transaction-sales-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',	
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'sale_order_no',
                        'value' => 'CHTml::link($data->sale_order_no, array("view", "id"=>$data->id))',
                        'type' => 'raw'
                    ),

                    'sale_order_date',
                    array(
                        'name'=>'customer_id',
                        'value'=>'empty($data->customer_id) ? "" : $data->customer->name'
                    ),
                    'status_document',
//                    'payment_type',
//                    'estimate_arrival_date',
                    array(
                        'name' => 'total_price',
                        'filter' => false,
                        'value' => 'number_format($data->total_price, 2)',
                    ),
                    'user.username: Maker',
                    'approval.username: Approval',
                    array(
                        'header' => 'Invoice #',
                        'filter' => false,
                        'value' => function ($data) {
                            $invoiceCriteria = new CDbCriteria;
                            $invoiceCriteria->addCondition("status !='CANCELLED'");
                            $invoiceCriteria->addCondition("sales_order_id = " . $data->id);
                            $invoice = InvoiceHeader::model()->find($invoiceCriteria);
                            $invoiceNumber = $invoice ? $invoice->invoice_number : "";
                            return $invoiceNumber;
                        }
                    ),
//                    array(
//                        'name' => 'requester_branch_id',
//                        'header' => 'Branch',
//                        'filter' => CHtml::activeDropDownList($model, 'requester_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
//                        'value' => 'empty($data->requesterBranch) ? "" : $data->requesterBranch->name',
//                    ),
                    array(
                        'header' => 'Status',
                        'value' => '$data->totalRemainingQuantityDelivered',
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                    /*
                    'requester_id',
                    'requester_branch_id',
                    'approved_id',
                    'approved_branch_id',
                    'customer_id',
                    'total_quantity',
                    'total_price',
                    'estimate_payment_date',
                    */
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit} {print}',
                        'buttons' => array(
                            'edit' => array(
                                'label' => 'edit',
                                'url' => 'Yii::app()->createUrl("transaction/transactionSalesOrder/update", array("id"=>$data->id))',
                                'visible' => '$data->status_document != "Approved" && $data->status_document != "Rejected" && Yii::app()->user->checkAccess("saleOrderEdit")',
                            ),
                            'print' => array(
                                'label' => 'print',
                                'url' => 'Yii::app()->createUrl("transaction/transactionSalesOrder/pdf", array("id"=>$data->id))',
                                'visible' => '$data->status_document == "Approved" && Yii::app()->user->checkAccess("saleOrderEdit")',
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>