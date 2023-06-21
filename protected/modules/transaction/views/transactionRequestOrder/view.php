<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */

$this->breadcrumbs = array(
    'Transaction Request Orders' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionRequestOrder', 'url' => array('index')),
    array('label' => 'Create TransactionRequestOrder', 'url' => array('create')),
    array('label' => 'Update TransactionRequestOrder', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete TransactionRequestOrder', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage TransactionRequestOrder', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Request', Yii::app()->baseUrl . '/transaction/transactionRequestOrder/admin', array('class' => 'button cbutton right')) ?>

        <?php if (Yii::app()->user->checkAccess("requestOrderEdit")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionRequestOrder/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>
        <?php if ($model->status_document == "Draft" && Yii::app()->user->checkAccess("requestOrderApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/transaction/transactionRequestOrder/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($model->status_document != "Draft" && Yii::app()->user->checkAccess("requestOrderSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/transactionRequestOrder/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>


<!--<a class="button cbutton right" style="margin-right:10px;" href="<?php //echo Yii::app()->createUrl('/transaction/'.$ccontroller.'/updateStatusBranch',array('id'=>$model->id)); ?>"><span class="fa fa-edit"></span>Branch Approval Status</a>	 --> 

        <h1>View Transaction Request #<?php echo $model->request_order_no; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'request_order_no',
                'request_order_date',
                array('name' => 'requester_id', 'value' => $model->user->username),
                array('name' => 'requester_branch_id', 'value' => $model->requesterBranch->name != "" ? $model->requesterBranch->name : ""),
                array('name' => 'main_branch_id', 'value' => $model->mainBranch->name != "" ? $model->mainBranch->name : ""),
                array('name' => 'main_branch_approved_id', 'value' => $model->mainBranchApproval != null ? $model->mainBranchApproval->username : null),
                array('name' => 'approved_by', 'value' => $model->approval != null ? $model->approval->username : null),
                array('name' => 'total_price', 'value' => $model->total_price, 'type' => 'number'),
                'total_items',
                'notes',
                'status_document',
            ),
        )); ?>
    </div>
</div>

<div class="detail">
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item' => array(
                'id' => 'test1',
                'content' => $this->renderPartial('_viewDetail', array(
                    'requestDetails' => $requestDetails,
                    'ccontroller' => $ccontroller,
                    'model' => $model
                ), TRUE)
            ),
            'Detail Approval' => array(
                'id' => 'test2',
                'content' => $this->renderPartial('_viewDetailApproval', array(
                    'model' => $model
                ), TRUE)
            ),
            'Detail Purchase' => array(
                'id' => 'test3',
                'content' => $this->renderPartial('_viewDetailPurchase', array(
                    'requestDetails' => $requestDetails,
                    'model' => $model
                ), TRUE)
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
    )); ?>
</div>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/responsive-tables.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/responsive-tables.js');
?>