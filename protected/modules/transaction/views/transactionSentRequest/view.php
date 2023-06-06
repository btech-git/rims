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
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Sent Request', Yii::app()->baseUrl . '/transaction/transactionSentRequest/admin', array(
            'class' => 'button cbutton right',
        )); ?>

        <?php //if ($model->status_document == "Draft"): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionSentRequest/update?id=' . $model->id, array(
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
                'visible' => Yii::app()->user->checkAccess("sentRequestEdit")
            )); ?>
        
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/transactionSentRequest/updateApproval?headerId=' . $model->id, array(
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
//                'visible' => Yii::app()->user->checkAccess("sentRequestEdit")
            )); ?>
        <?php //endif; ?>

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

    if (Yii::app()->user->checkAccess("generalManager")) {
        $tabsArray['Journal'] = array(
            'id' => 'test4',
            'content' => $this->renderPartial('_viewJournal', array('model' => $model), true)
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

<br />

<?php if (Yii::app()->user->checkAccess("generalManager") && $model->status_document === 'Approved'): ?>
    <div class="field buttons text-center">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
<?php endif; ?>