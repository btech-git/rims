<?php
/* @var $this TransactionSentRequestController */
/* @var $model TransactionSentRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Transaction Sent Request #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'sent_request_no',
                array('name' => 'sent_request_date', 'value' => $model->transactionDateTime),
                'status_document',
                'estimate_arrival_date',
                array(
                    'name' => 'requester_id', 
                    'value' => $model->user ? $model->user->username : null
                ),
                array(
                    'name' => 'requester_branch_id',
                    'value' => $model->requesterBranch ? $model->requesterBranch->name : ""
                ),
                array(
                    'name' => 'approve_by', 
                    'value' => $model->approval ? $model->approval->username : null
                ),
                array(
                    'name' => 'destination_branch_id',
                    'value' => $model->destinationBranch ? $model->destinationBranch->name : ""
                ),
                'total_quantity',
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
            'sentDetails' => $sentDetails, 
            'ccontroller' => $ccontroller, 
            'model' => $model
        ), true)
    );

    $tabsArray['Detail Approval'] = array(
        'id' => 'test2',
        'content' => $this->renderPartial('_viewDetailApproval', array('model' => $model), true)
    );

    $tabsArray['Detail Delivery'] = array(
        'id' => 'test3',
        'content' => $this->renderPartial('_viewDetailDelivery', array(
            'sentDetails' => $sentDetails, 
            'model' => $model
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
    ));
    ?>
</div>