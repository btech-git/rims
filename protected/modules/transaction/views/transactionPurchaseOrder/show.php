<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs=array(
	'Transaction Purchase Orders'=>array('admin'),
	$model->id,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
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
        'content'=>$this->renderPartial('_showDetail',  array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'ccontroller'=>$ccontroller,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Approval'] = array(
        'id'=>'test2',
        'content'=>$this->renderPartial('_showDetailApproval', array(
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Receive'] = array(
        'id'=>'test3',
        'content'=>$this->renderPartial('_showDetailReceive', array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Invoice'] = array(
        'id'=>'test4',
        'content'=>$this->renderPartial('_showDetailInvoice', array(
            'purchaseOrderDetails'=>$purchaseOrderDetails,
            'model'=>$model
        ),TRUE)
    );
    $tabsArray['Detail Payment'] = array(
        'id'=>'test5',
        'content'=>$this->renderPartial('_showDetailPayment', array(
            'model'=>$model
        ),TRUE)
    );
    ?>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => $tabsArray,
        // additional javascript options for the tabs plugin
        'options' => array('collapsible' => true),
        // set id for this widgets
        'id'=>'view_tab',
    )); ?>
</div>