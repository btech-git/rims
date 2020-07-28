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
        <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Purchase Order', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/admin', array('class'=>'button cbutton right','style'=>'margin-left:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.admin"))) ?>

        <?php if ($model->status_document != 'Approved' && $model->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.updateApproval"))) ?>
        <?php elseif ($model->status_document == 'Approved'): ?>
            <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment', Yii::app()->baseUrl.'/transaction/paymentOut/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentOut.create"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Print', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/pdf?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.pdf"))) ?>
        <?php else: ?>
            <?php echo ''; ?>;
        <?php endif; ?>
        <h1>View Transaction Purchase Order #<?php echo $model->id; ?></h1>

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
                'status_document',
                'payment_type',
                array('name' =>'requester_id','value'=> $model->user != null ? $model->user->username : null),
                array('name' =>'main_branch_id','value'=>$model->mainBranch->name),
                array('name' => 'approved_id', 'value'=> $model->approval != null ? $model->approval->username : null),
                array('name'=>'supplier_name','value'=>$model->supplier->name),
                'estimate_date_arrival',
                'estimate_payment_date',
            ),
        )); ?>
    </div>
</div>

<br />

<!--<div class="row">
    <div class="large-6 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">PPN</span>
                </div>
                <div class="small-5 columns">
                    <input type="text" readonly="true" value="<?php /*echo $model->ppn==1?"PPN":"No PPN"; ?>"> 
                </div>
                <div class="small-3 columns">
                    <?php /*if ($model->ppn == 1): ?>
                        <?php echo CHtml::link('NO PPN<span class="fa fa-question"></span>', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/ppn?id=' . $model->id .'&ppn_type=2', array('class'=>'button cbutton left','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.ppn"))) ?>
                    <?php else: ?>
                        <?php echo CHtml::link('PPN<span class="fa fa-question"></span>', Yii::app()->baseUrl.'/transaction/transactionPurchaseOrder/ppn?id=' . $model->id. '&ppn_type=1', array('class'=>'button cbutton left','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionPurchaseOrder.ppn"))) ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Sub Total</span>
                </div>
                <div class="small-8 columns">
                    <input type="text" readonly="true" value="<?php echo $this->format_money($model->subtotal); ?>">
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Total Price</span>
                </div>
                <div class="small-8 columns">
                    <input type="text" readonly="true" value="<?php echo Yii::app()->numberFormatter->format('#,##0.00', $model->total_price); ?>">
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">PPN price</span>
                </div>
                <div class="small-8 columns">
                    <input type="text" readonly="true" value="<?php echo $this->format_money($model->ppn_price); ?>">
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Total Quantity</span>
                </div>
                <div class="small-8 columns">
                    <input type="text" readonly="true" value="<?php echo $model->total_quantity;*/ ?>"> 
                </div>
            </div>
        </div>
    </div>
</div>-->
                    
<div class="detail">
	<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item'=>array(
                'id'=>'test1',
                'content'=>$this->renderPartial('_viewDetail',  array(
                    'purchaseOrderDetails'=>$purchaseOrderDetails,
                    'ccontroller'=>$ccontroller,
                    'model'=>$model
                ),TRUE)
            ),
            'Detail Approval'=>array(
                'id'=>'test2',
                'content'=>$this->renderPartial('_viewDetailApproval', array(
                    'model'=>$model
                ),TRUE)
            ),
            'Detail Receive'=>array(
                'id'=>'test3',
                'content'=>$this->renderPartial('_viewDetailReceive', array(
                    'purchaseOrderDetails'=>$purchaseOrderDetails,
                    'model'=>$model
                ),TRUE)
            ),
        ),                       

        // additional javascript options for the tabs plugin
        'options' => array('collapsible' => true),
        // set id for this widgets
        'id'=>'view_tab',
    )); ?>
</div>