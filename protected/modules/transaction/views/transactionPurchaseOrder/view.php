<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs=array(
	'Transaction Purchase Orders'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionPurchaseOrder', 'url'=>array('create')),
	array('label'=>'Update TransactionPurchaseOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionPurchaseOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionPurchaseOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->hasFlash('message')): ?>
            <div class="flash-error">
                <?php echo Yii::app()->user->getFlash('message'); ?>
            </div>
        <?php endif; ?>

        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Order', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/admin', array('class'=>'button cbutton right','style'=>'margin-left:10px')) ?>
        
        <?php if (Yii::app()->user->checkAccess("purchaseOrderEdit") && $model->status_document != 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px')) ?>
        <?php endif; ?>
        
        <?php if ($model->status_document != 'CANCELLED!!!'): //$model->status_document == 'Approved'): ?>
            <?php //echo CHtml::link('<span class="fa fa-plus"></span>Payment', Yii::app()->baseUrl.'/transaction/paymentOut/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.create"))) ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/pdf?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'target' => 'blank')) ?>
        <?php endif; ?>
        
        <?php if ($model->status_document == "Draft" && Yii::app()->user->checkAccess("purchaseOrderApproval") && $model->status_document != 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px')) ?>
        <?php elseif ($model->status_document != "Draft" && Yii::app()->user->checkAccess("purchaseOrderSupervisor") && $model->status_document != 'CANCELLED!!!'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px')) ?>
        <?php endif; ?>
        
        <?php //if (Yii::app()->user->checkAccess("saleInvoiceSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/transaction/transactionPurchaseOrder/cancel", "id" => $model->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php //endif; ?>
        
        <br />
        
        <h1>View Purchase Order #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'purchase_order_no',
                'purchase_order_date',
                array(
                    'name' =>'purchase_type',
                    'value'=>$model->getPurchaseStatus($model->purchase_type),
                ),
                array(
                    'name' =>'main_branch_id',
                    'value'=>$model->mainBranch->name
                ),
                array(
                    'name'=>'supplier_name',
                    'value'=>empty($model->supplier_id) ? "" : $model->supplier->name
                ),
                array(
                    'name' =>'registration_transaction_id',
                    'label' => 'Untuk WO #',
                    'value'=>empty($model->registration_transaction_id) ? '' : $model->registrationTransaction->work_order_number,
                ),
                'estimate_date_arrival',
                'payment_date_estimate',
                array(
                    'name' =>'coa_bank_id_estimate',
                    'label' => 'Akun Bank Estimasi',
                    'value'=>empty($model->coa_bank_id_stimate) ? '' : $model->coaBankIdEstimate->name,
                ),
                array(
                    'label' =>'Status Receive',
                    'value'=>$model->totalRemainingQuantityReceived
                ),
                'payment_status',
                'tax_percentage',
                array(
                    'name' =>'ppn',
                    'label' => 'PPN/NON',
                    'value'=>$model->getTaxStatus(),
                ),
                'status_document',
                'payment_type',
                array(
                    'label' => 'Created By',
                    'name' =>'requester_id',
                    'value'=> $model->user != null ? $model->user->username : null
                ),
                array(
                    'label' => 'Approved By',
                    'name' => 'approved_id', 
                    'value'=> $model->approval != null ? $model->approval->username : null
                ),
            ),
        )); ?>
    </div>
</div>

<br />
     
<div>
    <h3>Cabang Tujuan</h3>
    <table>
        <?php foreach($model->transactionPurchaseOrderDestinationBranches as $detail): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'branch.name')); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<br />
              
<div class="detail">
    <?php 
    $tabsArray = array(); 

    $tabsArray['Detail Item'] = array(
        'id'=>'test1',
        'content'=>$this->renderPartial('_viewDetail',  array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'ccontroller'=>$ccontroller,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Approval'] = array(
        'id'=>'test2',
        'content'=>$this->renderPartial('_viewDetailApproval', array(
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Receive'] = array(
        'id'=>'test3',
        'content'=>$this->renderPartial('_viewDetailReceive', array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Invoice'] = array(
        'id'=>'test4',
        'content'=>$this->renderPartial('_viewDetailInvoice', array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Payment'] = array(
        'id'=>'test5',
        'content'=>$this->renderPartial('_viewDetailPayment', array(
            'model'=>$model
        ),TRUE)
    );
    if (Yii::app()->user->checkAccess("generalManager")) {
        $tabsArray['Journal'] = array(
            'id'=>'test6',
            'content'=>$this->renderPartial('_viewJournal', array(
                'model'=>$model
            ),TRUE)
        );
    }
    ?>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => $tabsArray,
        // additional javascript options for the tabs plugin
        'options' => array('collapsible' => true),
        // set id for this widgets
        'id'=>'view_tab',
    )); ?>
</div>

<br />

<?php if ($model->status_document !== 'CANCELLED!!!'): // && Yii::app()->user->checkAccess("purchaseHead") && $model->status_document === 'Approved'): ?>
    <div class="field buttons text-center">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
<?php endif; ?>