<?php
/* @var $this TransactionSentRequestController */
/* @var $model TransactionSentRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionSentRequest', 'url' => array('index')),
    array('label' => 'Create TransactionSentRequest', 'url' => array('create')),
    array('label' => 'Update TransactionSentRequest', 'url' => array('update', 'id' => $model->id)),
    array(
        'label' => 'Delete TransactionSentRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
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
            Yii::app()->baseUrl . '/transaction/transactionSentRequest/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.transactionSentRequest.admin")
            )) ?>


        <?php if ($model->status_document != "Approved" && $model->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit',
                Yii::app()->baseUrl . '/transaction/transactionSentRequest/update?id=' . $model->id, array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transactionSentRequest.update")
                )) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval',
                Yii::app()->baseUrl . '/transaction/transactionSentRequest/updateApproval?headerId=' . $model->id,
                array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transactionSentRequest.updateApproval")
                )) ?>

        <?php endif ?>

        <h1>View TransactionSentRequest #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'sent_request_no',
                'sent_request_date',
                'status_document',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $model->user ? $model->user->username : null),
                array(
                    'name' => 'requester_branch_id',
                    'value' => $model->requesterBranch ? $model->requesterBranch->name : ""
                ),
                array('name' => 'approve_by', 'value' => $model->approval ? $model->approval->username : null),
                array(
                    'name' => 'destination_branch_id',
                    'value' => $model->destinationBranch ? $model->destinationBranch->name : ""
                ),
                'total_quantity',
                array(
                    'name' => 'total_price',
                    'value' => $this->format_money($model->total_price)
                )
            ))
        ); ?>

    </div>
</div>
<div class="detail">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial(
                    '_viewDetail',
                    array('sentDetails' => $sentDetails, 'ccontroller' => $ccontroller, 'model' => $model), true)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial(
                    '_viewDetailApproval',
                    array('model' => $model), true)
            ),
            //'Detail Approval'=>'',

            'Detail Delivery' => array(
                'id' => 'test3',
                'content' => $this->renderPartial(
                    '_viewDetailDelivery',
                    array('sentDetails' => $sentDetails, 'model' => $model), true)
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
	

