<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs=array(
    'Receive Items'=>array('admin'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List TransactionReceiveItem', 'url'=>array('index')),
    array('label'=>'Create TransactionReceiveItem', 'url'=>array('create')),
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
        $('#transaction-receive-item-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
");
?>
	
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Manage Transaction Receive Item</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
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
                'id'=>'transaction-receive-item-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'columns'=>array(
                    array(
                        'name'=>'receive_item_no', 
                        'value'=>'CHTml::link($data->receive_item_no, array("view", "id"=>$data->id))', 
                        'type'=>'raw',
                    ),
                    'receive_item_date',
                    'arrival_date',
                    array(
                        'name'=>'recipient_id',
                        'value'=>'(!empty($data->user->username)?$data->user->username:"")'
                    ),
                    array(
                        'name'=>'supplier_name',
                        'value'=>'empty($data->supplier) ? $data->destinationBranch->name : $data->supplier->name'
                    ),
                    array(
                        'name'=>'recipient_branch_id',
                        'filter' => CHtml::activeDropDownList($model, 'recipient_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value'=>'empty($data->recipient_branch_id) ? "" : $data->recipientBranch->name'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{edit}',
                        'buttons'=>array(
                            'edit' => array(
                                'label'=>'edit',
                                'url'=>'Yii::app()->createUrl("transaction/transactionReceiveItem/update", array("id"=>$data->id))',
                                'visible'=>'Yii::app()->user->checkAccess("receiveItemEdit")', //count(MovementInHeader::model()->findAllByAttributes(array("receive_item_id"=>$data->id))) == 0 &&  && ($data->request_type != "Retail Sales")'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>

        <fieldset>
            <legend>Pending Orders</legend>
            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Purchase Order' => array(
                            'content' => $this->renderPartial('_viewPurchaseOrder', array(
                                'purchase'=>$purchase,
                                'purchaseDataProvider'=>$purchaseDataProvider,
                            ), true)
                        ),
                        'Internal Delivery Order' => array(
                            'content' => $this->renderPartial('_viewDelivery', array(
                                'delivery'=>$delivery,
                                'deliveryDataProvider'=>$deliveryDataProvider,
                            ), true),
                        ),
                        'Movement Out' => array(
                            'content' => $this->renderPartial('_viewRetailSales', array(
                                'movement'=>$movement,
                                'movementDataProvider'=>$movementDataProvider,
                            ), true),
                        ),
                        'Consignment In' => array(
                            'content' => $this->renderPartial('_viewConsignment', array(
                                'consignment'=>$consignment,
                                'consignmentDataProvider'=>$consignmentDataProvider,
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
        </fieldset>
    </div>
</div>