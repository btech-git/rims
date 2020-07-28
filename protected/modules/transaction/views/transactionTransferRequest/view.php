<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionTransferRequest', 'url' => array('index')),
    array('label' => 'Create TransactionTransferRequest', 'url' => array('create')),
    array('label' => 'Update TransactionTransferRequest', 'url' => array('update', 'id' => $model->id)),
    array(
        'label' => 'Delete TransactionTransferRequest',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
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
            Yii::app()->baseUrl . '/transaction/transactionTransferRequest/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.transactionTransferRequest.admin")
            )) ?>

        <?php if ($model->status_document != 'Approved' && $model->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit',
                Yii::app()->baseUrl . '/transaction/transactionTransferRequest/update?id=' . $model->id, array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transactionTransferRequest.update")
                )) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval',
                Yii::app()->baseUrl . '/transaction/transactionTransferRequest/updateApproval?headerId=' . $model->id,
                array(
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("transaction.transactionTransferRequest.updateApproval")
                )) ?>

        <?php endif ?>

        <h1>View TransactionTransferRequest #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'transfer_request_no',
                'transfer_request_date',
                'status_document',
                'estimate_arrival_date',
                'requester_id',
                array('name' => 'requester_branch_id', 'value' => $model->requesterBranch->name),
                'approved_by',
                'destination_id',
                array('name' => 'destination_branch_id', 'value' => $model->destinationBranch->name),
                'total_quantity',
                array('name' => 'total_price', 'value' => $this->format_money($model->total_price))
            ),
        )); ?>

    </div>
</div>
<div class="detail">
    <?php
    $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial(
                    '_viewDetail',
                    array('transferDetails' => $transferDetails, 'ccontroller' => $ccontroller, 'model' => $model),
                    true)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial(
                    '_viewDetailApproval',
                    array('model' => $model), true)
            ),
            //'Detail Approval'=>'',

            'Detail Receive' => array(
                'id' => 'test3',
                'content' => $this->renderPartial(
                    '_viewDetailReceive',
                    array('transferDetails' => $transferDetails, 'model' => $model), true)
            ),
        ),


        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab',
    ));
    ?>
</div>
	

