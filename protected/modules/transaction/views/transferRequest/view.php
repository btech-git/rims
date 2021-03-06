﻿<?php
/* @var $this TransactionTransferRequestController */
/* @var $transferRequest TransactionTransferRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $transferRequest->id,
);

$this->menu = array(
    array('label' => 'List TransactionTransferRequest', 'url' => array('index')),
    array('label' => 'Create TransactionTransferRequest', 'url' => array('create')),
    array('label' => 'Update TransactionTransferRequest', 'url' => array('update', 'id' => $transferRequest->id)),
    array(
        'label' => 'Delete TransactionTransferRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $transferRequest->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage TransactionTransferRequest', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Transfer Request',
            Yii::app()->baseUrl . '/transaction/transferRequest/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.transferRequest.admin")
            ));  ?>

        <?php if ($transferRequest->status_document != 'Approved' && $transferRequest->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit',
                Yii::app()->baseUrl . '/transaction/transferRequest/update?id=' . $transferRequest->id, array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transferRequest.update")
                )); ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval',
                Yii::app()->baseUrl . '/transaction/transferRequest/updateApproval?headerId=' . $transferRequest->id,
                array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transferRequest.updateApproval")
                )); ?>
        <?php endif; ?>

        <h1>View Transaction Transfer Request #<?php echo $transferRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $transferRequest,
            'attributes' => array(
                'id',
                'transfer_request_no',
                'transfer_request_date',
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $transferRequest->user->username),
                array('name' => 'requester_branch_id', 'value' => $transferRequest->requesterBranch->name),
                array('name' => 'destination_branch_id', 'value' => $transferRequest->destinationBranch->name),
                array(
                    'name' => 'approved_by', 
                    'value' => empty($transferRequest->approvedBy) ? "" : $transferRequest->approvedBy->username
                ),
//                array('name' => 'total_price', 'value' => $this->format_money($transferRequest->total_price))
            ),
        )); ?>
    </div>
</div>

<div class="detail">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial(
                    '_viewDetail',
                    array('transferDetails' => $transferDetails, 'ccontroller' => $ccontroller, 'model' => $transferRequest),
                    true)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial(
                    '_viewDetailApproval',
                    array('model' => $transferRequest), true)
            ),
            //'Detail Approval'=>'',

            'Detail Receive' => array(
                'id' => 'test3',
                'content' => $this->renderPartial(
                    '_viewDetailReceive',
                    array('transferDetails' => $transferDetails, 'model' => $transferRequest), true)
            ),
            
            'Journal' => array(
                'id' => 'test4',
                'content' => $this->renderPartial('_viewJournal', array('model' => $transferRequest), true)
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
	

