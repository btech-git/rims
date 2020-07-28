<?php
/* @var $this TransactionSentRequestController */
/* @var $sentRequest TransactionSentRequest */

$this->breadcrumbs = array(
    'Transaction Sent Requests' => array('admin'),
    $sentRequest->id,
);

$this->menu = array(
    array('label' => 'List TransactionSentRequest', 'url' => array('index')),
    array('label' => 'Create TransactionSentRequest', 'url' => array('create')),
    array('label' => 'Update TransactionSentRequest', 'url' => array('update', 'id' => $sentRequest->id)),
    array(
        'label' => 'Delete TransactionSentRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $sentRequest->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => 'Manage TransactionSentRequest', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Sent Request',
            Yii::app()->baseUrl . '/transaction/sentRequest/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.sentRequest.admin")
            )) ?>

        <?php if ($sentRequest->status_document != 'Approved' && $transferRequest->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit',
                Yii::app()->baseUrl . '/transaction/sentRequest/update?id=' . $sentRequest->id, array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.sentRequest.update")
                )) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval',
                Yii::app()->baseUrl . '/transaction/sentRequest/updateApproval?headerId=' . $sentRequest->id,
                array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.sentRequest.updateApproval")
                )) ?>

        <?php endif ?>

        <h1>View TransactionSentRequest #<?php echo $sentRequest->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $sentRequest,
            'attributes' => array(
                'id',
                'sent_request_no',
                'sent_request_date',
                'status_document',
                'estimate_arrival_date',
                'requester_id',
                array('name' => 'requester_branch_id', 'value' => $sentRequest->requesterBranch->name),
                'approved_by',
                'destination_id',
                array('name' => 'destination_branch_id', 'value' => $sentRequest->destinationBranch->name),
                'total_quantity',
                array('name' => 'total_price', 'value' => $this->format_money($sentRequest->total_price))
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
                    array('sentDetails' => $sentDetails, 'ccontroller' => $ccontroller, 'model' => $sentRequest),
                    true)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial(
                    '_viewDetailApproval',
                    array('model' => $sentRequest), true)
            ),
            //'Detail Approval'=>'',

            'Detail Receive' => array(
                'id' => 'test3',
                'content' => $this->renderPartial(
                    '_viewDetailReceive',
                    array('sentDetails' => $sentDetails, 'model' => $sentRequest), true)
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
	

