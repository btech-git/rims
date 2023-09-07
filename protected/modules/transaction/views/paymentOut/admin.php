<?php
/* @var $this PaymentOutController */
/* @var $model PaymentOut */

$this->breadcrumbs = array(
    'Payment Outs' => array('index'),
    'Manage',
);

/*$this->menu=array(
	array('label'=>'List PaymentOut', 'url'=>array('index')),
	array('label'=>'Create PaymentOut', 'url'=>array('create')),
);*/

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
	$('#payment-out-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Payment Outs</h1>-->


<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New Payment Out',
                    Yii::app()->baseUrl . '/transaction/paymentOut/create', array(
                        'class' => 'button success right',
                        'visible' => Yii::app()->user->checkAccess("paymentOutCreate")
                    )) ?>
                <h2>Manage Payment Outs</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <!--<div class="left clearfix bulk-action">
                       <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                       <input type="submit" value="Archive" class="button secondary cbutton" name="archive">
                       <input type="submit" value="Delete" class="button secondary cbutton" name="delete">
                   </div>-->
                    <?php echo CHtml::link('Advanced Search', '#',
                        array('class' => 'search-button right button cbutton secondary')); ?>
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
                    'id' => 'payment-out-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        //'id',
                        //'purchase_order_id',
                        array(
                            'name' => 'purchase_order_number', 
                            'value' => 'empty($data->purchase_order_id) ? "N/A" : $data->purchaseOrder->purchase_order_no'
                        ),
                        array(
                            'name' => 'payment_number',
                            'value' => 'CHTml::link($data->payment_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        //'payment_number',
                        'payment_type',
                        'payment_date',
                        array(
                            'name' => 'supplier_name', 
                            'value' => 'empty($data->supplier_id) ? "N/A" : $data->supplier->name'
                        ),
                        array(
                            'name' => 'payment_amount', 
                            'value' => 'AppHelper::formatMoney($data->payment_amount)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'name' => 'branch_id', 
                            'filter' => CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->branch->name'
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '$data->status',
                        ),
                    ),
                )); ?>
            </div>
            <fieldset>
                <legend>PO Pending Payment</legend>
                
                <div class="grid-view">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'purchase-order-grid',
                        // 'dataProvider'=>$vehicleDataProvider,
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
                                'value' => 'CHTml::link($data->purchase_order_no, array("transactionPurchaseOrder/view", "id"=>$data->id))',
                                'type' => 'raw'
                            ),
                            //'invoice_number',
                            'purchase_order_date',
                            //'due_date',
                            'status_document',
                            array('name' => 'supplier_name', 'value' => '$data->supplier->name'),
                            array(
                                'name' => 'total_price', 
                                'value' => 'AppHelper::formatMoney($data->total_price)'
                            ),
                        ),
                    )); ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
