<?php
/* @var $this TransactionDeliveryOrderController */
/* @var $model TransactionDeliveryOrder */

$this->breadcrumbs = array(
    'Transaction Delivery Orders' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List TransactionDeliveryOrder', 'url' => array('admin')),
    array('label' => 'Create TransactionDeliveryOrder', 'url' => array('create')),
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
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php //echo CHtml::link('<span class="fa fa-plus"></span>New Delivery Order', Yii::app()->baseUrl . '/transaction/transactionDeliveryOrder/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.create"))) ?>
        <h1>Manage Delivery Orders</h1>
        
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search', array(
                        'model' => $model,
                    )); ?>
                </div>			
            </div>
        </div>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'transaction-delivery-order-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'delivery_order_no', 
                        'value' => 'CHTml::link($data->delivery_order_no, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'delivery_date',
                    'posting_date',
                    array(
                        'name' => 'sender_id',
                        'value' => '!empty($data->sender_id) ? $data->sender->username : ""'
                    ),
                    array(
                        'name' => 'request_type',
                        'value' => '$data->request_type',
                    ),
                    array(
                        'header' => 'Movement Out',
                        'value' => 'empty($data->movementOutHeaders) ? "Belum Diproses" : "Selesai"'
                    ),
                    array(
                        'header' => 'Input',
                        'name' => 'created_datetime',
                        'filter' => false,
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                    ),
//                    array(
//                        'class' => 'CButtonColumn',
//                        'template' => '{print}',
//                        'buttons' => array(
//                            'edit' => array(
//                                'label' => 'edit',
//                                'url' => 'Yii::app()->createUrl("transaction/transactionDeliveryOrder/update", array("id"=>$data->id))',
//                                'visible' => 'Yii::app()->user->checkAccess("deliveryEdit")', //count(MovementOutHeader::model()->findAllByAttributes(array("delivery_order_id"=>$data->id))) == 0 && ',
//                            ),
//                            'print' => array(
//                                'label' => 'print',
//                                'url' => 'Yii::app()->createUrl("transaction/transactionDeliveryOrder/pdf", array("id"=>$data->id))',
//                                'visible' => 'count(MovementOutHeader::model()->findAllByAttributes(array("delivery_order_id"=>$data->id))) != 0 && Yii::app()->user->checkAccess("deliveryEdit")',
//                            ),
//                        ),
//                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Transfer Request' => array(
                'content' => $this->renderPartial('_viewTransfer', array(
                    'transferDataProvider' => $transferDataProvider, 
                    'transfer' => $transfer, 
                    'model' => $model
                ), true),
            ),
            'Sent Request' => array(
                'content' => $this->renderPartial('_viewSent', array(
                    'sentDataProvider' => $sentDataProvider, 
                    'sent' => $sent, 
                    'model' => $model
                ), true),
            ),
            'Sales Order' => array(
                'content' => $this->renderPartial('_viewSales', array(
                    'salesDataProvider' => $salesDataProvider, 
                    'sales' => $sales, 
                    'model' => $model
                ), true),
            ),
            'Consignment Out' => array(
                'content' => $this->renderPartial('_viewConsignment', array(
                    'consignmentDataProvider' => $consignmentDataProvider, 
                    'consignment' => $consignment, 
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