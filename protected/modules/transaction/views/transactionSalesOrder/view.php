<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs = array(
    'Transaction Sales Orders' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionSalesOrder', 'url' => array('index')),
    array('label' => 'Create TransactionSalesOrder', 'url' => array('create')),
    array('label' => 'Update TransactionSalesOrder', 'url' => array('update', 'id' => $model->id)),
    array(
        'label' => 'Delete TransactionSalesOrder',
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => 'Are you sure you want to delete this item?'
        ),
    ),
    array('label' => 'Manage TransactionSalesOrder', 'url' => array('admin')),
);
?>


<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', Yii::app()->baseUrl . '/transaction/transactionSalesOrder/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("transaction.transactionSalesOrder.admin")
        )); ?>

        <?php if (Yii::app()->user->checkAccess("saleOrderEdit")): //$model->status_document != 'Approved' && $model->status_document != 'Rejected'): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionSalesOrder/update?id=' . $model->id, array(
                'class' => 'button warning right',
                'style' => 'margin-right:10px',
            )); ?>
        <?php else : ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print', Yii::app()->baseUrl . '/transaction/transactionSalesOrder/pdf?id=' . $model->id, array(
                'class' => 'button warning right',
                'style' => 'margin-right:10px',
            )); ?>
        <?php endif; ?>
        
        <?php if ($model->status_document == "Draft" && Yii::app()->user->checkAccess("saleOrderApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl.'/transaction/transactionSalesOrder/updateApproval?headerId=' . $model->id , array(
                'class'=>'button success right',
                'style'=>'margin-right:10px'
            )) ?>
        <?php elseif ($model->status_document != "Draft" && Yii::app()->user->checkAccess("saleOrderSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/transactionSalesOrder/updateApproval?headerId=' . $model->id , array(
                'class'=>'button success right',
                'style'=>'margin-right:10px'
            )) ?>
        <?php endif; ?>
        
        <?php $checkInvoices = InvoiceHeader::model()->findAllByAttributes(array('sales_order_id' => $model->id)); ?>
        <?php if (count($checkInvoices) == 0): ?>
            <?php echo CHtml::link('<span class="fa fa-plus"></span>Generate Invoice', array(
                "/transaction/invoiceHeader/createSaleOrder", 
                "saleOrderId" => $model->id
            ), array(
                'class' => 'button success right', 
                'style' => 'margin-right:10px',
                'visible' => Yii::app()->user->checkAccess("saleOrderCreate") || Yii::app()->user->checkAccess("saleOrderEdit")
            )); ?>
        <?php /*else: ?>
            <?php echo CHtml::button('Generate Invoice', array(
                'id' => 'invoice-button',
                'name' => 'Invoice',
                'class' => 'button cbutton right',
                'style' => 'margin-right:10px',
                'onclick' => ' 
                if (confirm("Invoice for this sales order has been created. are you sure to reGENERATE it?")){
                    $.ajax({
                        type: "POST",
                        //dataType: "JSON",
                        url: "' . CController::createUrl('generateInvoice', array('id' => $model->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) {
                            alert("Invoice Succesfully Generated");
                            location.reload();
                        },
                    })
                } else {
                    alert("No new invoice generated.");
                }
                '
            ));*/ ?>
        <?php endif; ?>

        <h1>View Transaction Sales Orders #<?php echo $model->sale_order_no; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'sale_order_no',
                'sale_order_date',
                'status_document',
                'payment_type',
                'estimate_arrival_date',
                array(
                    'name' => 'requester_id', 
                    'value' => $model->user != null ? $model->user->username : ''
                ),
                array(
                    'name' => 'requester_branch_id', 
                    'value' => $model->requesterBranch->name
                ),
                array(
                    'name' => 'approved_id', 
                    'value' => $model->approval != null ? $model->approval->username : ''
                ),
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

<br /><br />

<div class="detail">
    <?php 
    $tabsArray = array(); 

    $tabsArray['Detail Item'] = array(
        'id' => 'test1',
        'content' => $this->renderPartial('_viewDetail', array(
            'model' => $model, 
            'salesOrderDetails' => $salesOrderDetails, 
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
            'salesOrderDetails' => $salesOrderDetails, 
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
        'options' => array('collapsible' => true,),
        // set id for this widgets
        'id' => 'view_tab',
    ));
    ?>
</div>

<br />

<div class="field buttons text-center">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
    <?php echo CHtml::endForm(); ?>
</div>