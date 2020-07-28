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
                
<div class="detail">
	<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Detail Item'=>array(
                'id'=>'test1',
                'content'=>$this->renderPartial('_viewDetailPurchase',  array(
                    'purchaseOrderDetails'=>$purchaseOrderDetails,
                    'ccontroller'=>$ccontroller,
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