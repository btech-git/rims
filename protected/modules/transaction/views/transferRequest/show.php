<?php
/* @var $this TransactionTransferRequestController */
/* @var $transferRequest TransactionTransferRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $transferRequest->id,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>View Transaction Transfer Request #<?php echo $transferRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $transferRequest,
            'attributes' => array(
                'transfer_request_no',
                array('name' => 'transfer_request_date', 'value' => $transferRequest->transactionDateTime),
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $transferRequest->user->username),
                array('name' => 'requester_branch_id', 'value' => $transferRequest->requesterBranch->name),
                array('name' => 'destination_branch_id', 'value' => $transferRequest->destinationBranch->name),
                array(
                    'name' => 'approved_by', 
                    'value' => empty($transferRequest->approvedBy) ? "" : $transferRequest->approvedBy->username
                ),
            ),
        )); ?>
    </div>
</div>

<br />

<div class="detail">
    <?php 
    $tabsArray = array(); 

    $tabsArray['Detail Item'] = array(
        'id' => 'test1',
        'content' => $this->renderPartial('_viewDetail', array(
            'transferDetails' => $transferDetails, 
            'ccontroller' => $ccontroller, 
            'model' => $transferRequest
        ), true)
    );

    $tabsArray['Detail Approval'] = array(
        'id' => 'test2',
        'content' => $this->renderPartial('_viewDetailApproval', array(
            'model' => $transferRequest
        ), true)
    );

    $tabsArray['Detail Receive'] = array(
        'id' => 'test3',
        'content' => $this->renderPartial('_viewDetailReceive', array(
            'transferDetails' => $transferDetails,
            'model' => $transferRequest
        ), true)
    );
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