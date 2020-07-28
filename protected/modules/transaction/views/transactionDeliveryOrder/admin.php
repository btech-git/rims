<?php
/* @var $this TransactionDeliveryOrderController */
/* @var $model TransactionDeliveryOrder */

$this->breadcrumbs=array(
	'Transaction Delivery Orders'=>array('admin'),
	'Manage',
	);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrder', 'url'=>array('admin')),
	array('label'=>'Create TransactionDeliveryOrder', 'url'=>array('create')),
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
		$('#transaction-delivery-order-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-plus"></span>New Delivery Order', Yii::app()->baseUrl.'/transaction/transactionDeliveryOrder/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.create"))) ?>
        <h1>Manage Transaction Delivery Orders</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                    )); ?>
                </div>			
            </div>
         </div>

         <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'transaction-delivery-order-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                'columns'=>array(
                    array('name'=>'delivery_order_no', 'value'=>'CHTml::link($data->delivery_order_no, array("view", "id"=>$data->id))', 'type'=>'raw'),
                    'delivery_date',
                    'posting_date',
                    array(
                        'name'=>'customer_name',
                        'value'=>'(!empty($data->customer->name)?$data->customer->name:"")'
                    ),
                    array(
                        'name'=>'sender_id',
                        'value'=>'(!empty($data->user->username)?$data->user->username:"")'
                    ),
                    array(
                        'name'=>'branch_name',
                        'value'=>'$data->senderBranch->name'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{edit} {print}',
                        'buttons'=>array(
                            'edit' => array(
                                'label'=>'edit',
                                'url'=>'Yii::app()->createUrl("transaction/transactionDeliveryOrder/update", array("id"=>$data->id))',
                                'visible'=>'count(MovementOutHeader::model()->findAllByAttributes(array("delivery_order_id"=>$data->id))) == 0 && Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.update")',
                            ),
                            'print' => array(
                                'label'=>'print',
                                'url'=>'Yii::app()->createUrl("transaction/transactionDeliveryOrder/pdf", array("id"=>$data->id))',
                                'visible'=>'count(MovementOutHeader::model()->findAllByAttributes(array("delivery_order_id"=>$data->id))) != 0 && Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.pdf")',
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
        <!--<fieldset>
            <legend>Pending Orders</legend>
            <h2>Sales Order</h2>
            <?php /*$this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'sales-grid',
                'dataProvider'=>$salesDataProvider,
                'filter'=>$sales,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                //'summaryText'=>'',
                'columns'=>array(
                    //'id',
                    //'code',
                    array('name'=>'sale_order_no', 'value'=>'CHTml::link($data->sale_order_no, array("/transaction/transactionSalesOrder/view", "id"=>$data->id))', 'type'=>'raw'),
                    // 'purchase_order_no',
                    'sale_order_date',
                    'status_document',
                    array('header'=>'Deliveries','value'=> function($data){
                        if(count($data->transactionDeliveryOrders) >0) {
                            foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                                echo $delivery->delivery_order_no. "<br>";

                            }
                        }
                    }
                )),
            )); ?>
            <h2>Transfer Request</h2>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'transfer-grid',
                'dataProvider'=>$transferDataProvider,
                'filter'=>$transfer,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                //'summaryText'=>'',
                'columns'=>array(
                    //'id',
                    //'code',
                    array('name'=>'transfer_request_no', 'value'=>'CHTml::link($data->transfer_request_no, array("/transaction/transactionTransferRequest/view", "id"=>$data->id))', 'type'=>'raw'),
                    // 'purchase_order_no',
                    'transfer_request_date',
                    'status_document',
                    array('header'=>'Deliveries','value'=> function($data){
                        if(count($data->transactionDeliveryOrders) >0) {
                            foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                                echo $delivery->delivery_order_no. "<br>";
                            }
                        }
                    }
                )),
            )); ?>
            <h2>Sent Request</h2>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'sent-grid',
                'dataProvider'=>$sentDataProvider,
                'filter'=>$sent,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                //'summaryText'=>'',
                'columns'=>array(
                    //'id',
                    //'code',
                    array('name'=>'sent_request_no', 'value'=>'CHTml::link($data->sent_request_no, array("/transaction/transactionSentRequest/view", "id"=>$data->id))', 'type'=>'raw'),
                    // 'purchase_order_no',
                    'sent_request_date',
                    'status_document',
                    array('header'=>'Receives','value'=> function($data){
                        if(count($data->transactionDeliveryOrders) >0) {
                            foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                                echo $delivery->delivery_order_no. "<br>";

                            }
                        }
                    }
                )),
            )); ?>
            <h2>Consignment Out</h2>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'consignment-grid',
                'dataProvider'=>$consignmentDataProvider,
                'filter'=>$consignment,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                    ),
                //'summaryText'=>'',
                'columns'=>array(
                    //'id',
                    //'code',
                    array('name'=>'consignment_out_no', 'value'=>'CHTml::link($data->consignment_out_no, array("/transaction/consignmentOutHeader/view", "id"=>$data->id))', 'type'=>'raw'),
                    // 'purchase_order_no',
                    'date_posting',
                    'status',
                    array('header'=>'Receives','value'=> function($data){
                        if(count($data->transactionDeliveryOrders) >0) {
                            foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                                echo $delivery->delivery_order_no. "<br>";
                            }
                        }
                    }
                )),
            ));*/ ?>
        </fieldset>-->
    </div>
</div>

<div>
    
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Sales Order' => array(
                'content' => $this->renderPartial(
                    '_viewSales',
                    array('salesDataProvider' => $salesDataProvider, 'sales' => $sales, 'model' => $model),
                    true
                )
            ),
            'Transfer Request' => array(
                'content' => $this->renderPartial(
                    '_viewTransfer',
                    array('transferDataProvider' => $transferDataProvider, 'transfer' => $transfer, 'model' => $model),
                    true
                )
            ),
            'Sent Request' => array(
                'content' => $this->renderPartial(
                    '_viewSent',
                    array('sentDataProvider' => $sentDataProvider, 'sent' => $sent, 'model' => $model),
                    true
                )
            ),
            'Consignment Out' => array(
                'content' => $this->renderPartial(
                    '_viewConsignment',
                    array('consignmentDataProvider' => $consignmentDataProvider, 'consignment' => $consignment, 'model' => $model),
                    true
                )
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