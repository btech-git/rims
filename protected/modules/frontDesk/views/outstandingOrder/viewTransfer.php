<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs = array(
    'Transfer Request' => array('admin'),
    $model->id,
);
?>


<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>View Transfer Request #<?php echo $model->transfer_request_no; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'transfer_request_no',
                'transfer_request_date',
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $model->user != null ? $model->user->username : ''),
                array('name' => 'requester_branch_id', 'value' => $model->requesterBranch->name),
                array('name' => 'approved_by', 'value' => $model->approved_by != null ? $model->approvedBy->username : ''),
                array('name' => 'destination_branch_id', 'value' => $model->destinationBranch->name),
                
            ),
        )); ?>

    </div>
</div>
<div class="detail">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial('_viewDetailTransfer', array(
                    'model' => $model, 
                    'transferRequestDetails' => $transferRequestDetails, 
                    'ccontroller' => $ccontroller, 
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