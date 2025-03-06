<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs = array(
    'Movement In Headers' => array('admin'),
    $model->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Movement In Header #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'movement_in_number',
                'date_posting',
                array(
                    'name' => 'branch_id', 
                    'value' => $model->branch_id == "" ? '-' : $model->branch->name,
                ),
                'status',
                'created_datetime',
            ),
        )); ?>
    </div>
</div>

<br />

<div class="detail">
    <div class="row">
        <div class="small-8">
            <div class="row">
                <div class="small-3 columns">
                    <label for="right-label" class="right" style="font-weight:bold;">Movement Type</label>
                </div>
                <div class="small-9 columns">
                    <?php
                    if ($model->movement_type == 1) {
                        $movementType = "Receive Item";
                    } elseif ($model->movement_type == 2) {
                        $movementType = "Return Penjualan";
                    } else {
                        $movementType = "";
                    }
                    ?>

                    <label for=""><?php echo $movementType; ?></label>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($model->movement_type == 1): ?>
        <?php
        $receive = TransactionReceiveItem::model()->findByPk($model->receive_item_id);
        if (!empty($receive)) {
            if ($receive->request_type == "Internal Delivery Order") {
                $type = "Internal Delivery Order";
                $requestNumber = CHTml::link($receive->deliveryOrder->delivery_order_no, array("/transaction/transactionDeliveryOrder/show", "id" => $receive->delivery_order_id), array('target' => 'blank'));
            } elseif ($receive->request_type == "Purchase Order") {
                $type = "Purchase Order";
                $requestNumber = CHTml::link($receive->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/show", "id" => $receive->purchase_order_id), array('target' => 'blank'));
            } elseif ($receive->request_type == "Consignment In") {
                $type = "Consignment In";
                $requestNumber = CHTml::link($receive->consignmentIn->consignment_in_number, array("/transaction/consignmentIn/show", "id" => $receive->consignment_in_id), array('target' => 'blank'));
            }
        }
        ?>
    
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Penerimaan #</label>
                    </div>
                    
                    <div class="small-9 columns">
                        <label for=""><?php echo empty($receive) ? "N/A" : CHtml::link($receive->receive_item_no, array("/transaction/transactionReceiveItem/show", "id" => $receive->id), array('target' => 'blank')); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference Type</label>
                    </div>
                    <div class="small-9 columns">
                        <label for=""><?php echo empty($type) ? "N/A" : $type; ?></label>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
                    </div>
                    
                    <div class="small-9 columns">
                        <label for=""><?php echo empty($requestNumber) ? "N/A" : $requestNumber; ?></label>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
                    </div>
                    
                    <div class="small-9 columns">
                        <label for=""><?php echo $model->return_item_id != "" ? CHTml::link($model->returnItem->return_item_no, array("/transaction/transactionReturnItem/show", "id" => $model->return_item_id), array('target' => 'blank')) : ""; ?></label>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<br />

<div class="detail">
    <?php 
    $tabsArray = array(); 

    $tabsArray['Detail Item'] = array(
        'id' => 'test1', 
        'content' => $this->renderPartial('_viewDetail', array('details' => $details), TRUE)
    );
    $tabsArray['Detail Approval'] = array(
        'id' => 'test2', 
        'content' => $this->renderPartial('_viewDetailApproval', array('historis' => $historis), TRUE)
    );
    $tabsArray['Detail Distribution'] = array(
        'id' => 'test3', 
        'content' => $this->renderPartial('_viewDetailShipping', array('shippings' => $shippings), TRUE)
    );
    if (Yii::app()->user->checkAccess("generalManager")) {
        $tabsArray['Journal'] = array(
            'id' => 'test4', 
            'content' => $this->renderPartial('_viewJournal', array('model' => $model), TRUE)
        );
    }
    ?>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => $tabsArray,
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab',
    ));
    ?>
</div>