<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs = array(
    'Movement Out Headers' => array('admin'),
    $model->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Movement Out Header #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'movement_out_no',
                'date_posting',
                array(
                    'name' => 'branch_id', 
                    'value' => $model->branch_id == "" ? '-' : $model->branch->name
                ),
                'user.username',
                'status',
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
                        $movementType = "Delivery Order";
                    } elseif ($model->movement_type == 2) {
                        $movementType = "Return Order";
                    } elseif ($model->movement_type == 3) {
                        $movementType = "GR/BR";
                    } elseif ($model->movement_type == 4) {
                        $movementType = "Permintaan Bahan";
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
        $delivery = TransactionDeliveryOrder::model()->findByPk($model->delivery_order_id);
        if (!empty($delivery)) {
            if ($delivery->request_type == "Sales Order") {
                $type = "Sales Order";
                $requestNumber = CHTml::link($delivery->salesOrder->sale_order_no, array("/transaction/transactionSalesOrder/show", "id" => $delivery->sales_order_id), array('target' => 'blank'));
            } elseif ($delivery->request_type == "Sent Request") {
                $type = "Sent Request";
                $requestNumber = CHTml::link($delivery->sentRequest->sent_request_no, array("/transaction/transactionSentRequest/show", "id" => $delivery->sent_request_id), array('target' => 'blank'));
            } elseif ($delivery->request_type == "Consignment Out") {
                $type = "Consignment out";
                $requestNumber = CHTml::link($delivery->consignmentOut->consignment_out_no, array("/transaction/consignmentOut/show", "id" => $delivery->consignment_out_id), array('target' => 'blank'));
            } elseif ($delivery->request_type == "Transfer Request") {
                $type = "Transfer Request";
                $requestNumber = CHTml::link($delivery->transferRequest->transfer_request_no, array("/transaction/transferRequest/show", "id" => $delivery->transfer_request_id), array('target' => 'blank'));
            }
        }
        ?>
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference Type</label>
                    </div>
                    <div class="small-9 columns">
                        <label for=""><?php echo !empty($type) ? $type : ""; ?></label>
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
                        <label for=""><?php echo !empty($requestNumber) ? $requestNumber : ""; ?></label>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->movement_type == 2): ?>
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
                    </div>
                    <div class="small-9 columns">
                        <label for=""><?php echo $model->return_order_id != "" ? CHTml::link($model->returnOrder->return_order_no, array("/transaction/transactionReturnOrder/show", "id" => $model->return_order_id), array('target' => 'blank')) : ""; ?></label>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->movement_type == 4): ?>
        <div class="row">
            <div class="small-8">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
                    </div>
                    <div class="small-9 columns">
                        <label for=""><?php echo $model->material_request_header_id != "" ? CHTml::link($model->materialRequestHeader->transaction_number, array("/frontDesk/materialRequest/show", "id" => $model->material_request_header_id), array('target' => 'blank')) : ""; ?></label>
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
                        <label for=""><?php echo $model->registration_transaction_id != "" ? CHTml::link($model->registrationTransaction->transaction_number, array($model->registrationTransaction->repair_type == "GR" ? "/frontDesk/generalRepairRegistration/view" : "/frontDesk/bodyRepairRegistration/show", "id" => $model->registration_transaction_id), array('target' => 'blank')) : ""; ?></label>
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
    )); ?>
</div>