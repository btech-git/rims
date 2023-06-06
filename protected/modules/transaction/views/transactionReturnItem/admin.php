<?php
/* @var $this TransactionReturnItemController */
/* @var $model TransactionReturnItem */

$this->breadcrumbs = array(
    'Transaction Return Items' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionReturnItem', 'url' => array('admin')),
    array('label' => 'Create TransactionReturnItem', 'url' => array('create')),
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
	$('#transaction-return-item-grid').yiiGridView('update', {
            data: $(this).serialize()
	});
        
	return false;
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php //echo CHtml::link('<span class="fa fa-plus"></span>New Return Item', Yii::app()->baseUrl . '/transaction/transactionReturnItem/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("saleReturnCreate"))) ?>

        <h1>Manage Transaction Return Jual</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
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
                'id' => 'transaction-return-item-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'return_item_no', 
                        'value' => 'CHtml::link($data->return_item_no, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'return_item_date',
                    array(
                        'header' => 'Reference #', 
                        'value' => 'empty($data->delivery_order_id) ? CHtml::link($data->registrationTransaction->transaction_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->registration_transaction_id), array("target" => "blank")) : CHtml::link($data->deliveryOrder->delivery_order_no, array("/transaction/transactionDeliveryOrder/view", "id"=>$data->delivery_order_id), array("target" => "blank"))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'customer_name',
                        'value' => '!empty($data->customer->name) ? $data->customer->name : "" '
                    ),
                    array(
                        'name' => 'recipient_id',
                        'value' => '!empty($data->user->username) ? $data->user->username : ""'
                    ),
                    array(
                        'name' => 'recipient_branch_id',
                        'value' => '$data->recipientBranch->name'
                    ),
                    array(
                        'name'=>'destination_branch',
                        'value'=>'$data->destinationBranch->name'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array(
                            'edit' => array(
                                'label' => 'edit',
                                'url' => 'Yii::app()->createUrl("transaction/transactionReturnItem/update", array("id"=>$data->id))',
                                'visible' => 'Yii::app()->user->checkAccess("saleReturnEdit")', //count(MovementInHeader::model()->findAllByAttributes(array("return_item_id"=>$data->id))) == 0 &&  && $data->status != "Rejected"'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
        
        <hr /><br />
        
        <h3>Pending Order</h3>
        <div>
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Retail GR / BR' => array(
                        'content' => $this->renderPartial('_viewRetail', array(
                            'retailTransaction' => $retailTransaction,
                            'retailTransactionDataProvider' => $retailTransactionDataProvider,
                            'model' => $model
                        ), true),
                    ),
                    'Delivery' => array(
                        'content' => $this->renderPartial('_viewDelivery', array(
                            'delivery' => $delivery,
                            'deliveryDataProvider' => $deliveryDataProvider,
                            'model' => $model
                        ), true),
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
    </div>
</div>