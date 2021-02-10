<?php
/* @var $this InvoiceHeaderController */
/* @var $invoice->header InvoiceHeader */

$this->breadcrumbs=array(
    'Invoice Headers'=>array('admin'),
    $invoice->header->id=>array('view','id'=>$invoice->header->id),
    'Update',
);

?>

<!--<h1>Update InvoiceHeader <?php //echo $invoice->header->id; ?></h1>-->

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <h1>Update Transaction Purchase Order #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'purchase_order_no',
                'purchase_order_date',
                array(
                    'name' =>'purchase_type',
                    'value'=>$model->getPurchaseStatus($model->purchase_type),
                ),
                array(
                    'name' =>'ppn',
                    'label' => 'PPN/NON',
                    'value'=>$model->getTaxStatus(),
                ),
                'status_document',
                'payment_type',
                array('name' =>'requester_id','value'=> $model->user != null ? $model->user->username : null),
                array('name' =>'main_branch_id','value'=>$model->mainBranch->name),
                array('name' => 'approved_id', 'value'=> $model->approval != null ? $model->approval->username : null),
                array('name'=>'supplier_name','value'=>$model->supplier->name),
                'estimate_date_arrival',
            ),
        )); ?>
    </div>
</div>

<br />

<div class="clearfix page-action">
    <table>
        <tr>
            <td width="10%">Payment Bank</td>
            <td width="30%">
                <?php echo CHtml::activeDropDownlist($model, 'coa_bank_id_estimate', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 2)), 'id', 'name'), array(
                    'empty' => '[--Select Payment Bank--]',
                )); ?>
            </td>
            <td width="10%">Payment Est Date</td>
            <td width="30%">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                    'attribute' => 'payment_date_estimate',
                    'options'=>array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth'=>true,
                        'changeYear'=>true,
                    ),
                    'htmlOptions'=>array(
                        'readonly' => true,
                    ),
                )); ?>
            </td>
        </tr>
    </table>

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Update', array('name' => 'Update', 'class' => 'button cbutton', 'confirm' => 'Are you sure you want to update?')); ?>
    </div>
</div>
<br />
              
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
            'Detail Invoice'=>array(
                'id'=>'test4',
                'content'=>$this->renderPartial('_viewDetailInvoice', array(
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

<?php echo CHtml::endForm(); ?>