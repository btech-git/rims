<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs = array(
    'Transaction Sales Orders' => array('admin'),
    $model->id,
);
?>


<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>View Transaction Sales Orders #<?php echo $model->sale_order_no; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'sale_order_no',
                'sale_order_date',
                'status_document',
                'payment_type',
                'estimate_arrival_date',
                array('name' => 'requester_id', 'value' => $model->user != null ? $model->user->username : ''),
                array('name' => 'requester_branch_id', 'value' => $model->requesterBranch->name),
                array('name' => 'approved_id', 'value' => $model->approval != null ? $model->approval->username : ''),
                array(
                    'name' => 'approved_branch_id',
                    'value' => $model->approvedBranch != null ? $model->approvedBranch->name : ''
                ),
                array('name' => 'customer_name', 'value' => $model->customer->name),
                'estimate_payment_date',
                array(
                    'label' => 'Invoice #',
                    'value' => $model->invoiceHeaders != null ? $model->invoiceHeaders[0]->invoice_number : 'N/A'
                ),
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
                    '_viewDetailSale',
                    array('model' => $model, 'saleOrderDetails' => $saleOrderDetails, 'ccontroller' => $ccontroller, 'model' => $model),
                    true
                ),
            ),
            
            'Detail Delivery' => array(
                'id' => 'test3',
                'content' => $this->renderPartial(
                    '_viewDetailDelivery',
                    array('saleOrderDetails' => $saleOrderDetails, 'model' => $model), true
                ),
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