<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Manage',
);

/*$this->menu=array(
	array('label'=>'List PaymentIn', 'url'=>array('index')),
	array('label'=>'Create PaymentIn', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    
    return false;
});
$('.search-form form').submit(function(){
    $('#payment-in-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php /*echo CHtml::link('<span class="fa fa-list" ></span>Unpaid Invoice List',
                    Yii::app()->baseUrl . '/transaction/paymentIn/index', array(
                        'class' => 'button cbutton right',
                        'style' => 'margin-left:10px',
                        'visible' => Yii::app()->user->checkAccess("paymentInCreate") || Yii::app()->user->checkAccess("paymentInEdit")
                    ));*/ ?>
                <?php /*echo CHtml::link('<span class="fa fa-plus"></span>New Payment In',
                    Yii::app()->baseUrl . '/transaction/paymentIn/invoiceList', array(
                        'class' => 'button success right',
                        'visible' => Yii::app()->user->checkAccess("paymentInCreate")
                    ));*/ ?>
                <h2>Manage Payment In</h2>
                
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment by Customer', Yii::app()->baseUrl . '/transaction/paymentIn/customerList', array(
                    'class' => 'button success right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("paymentInCreate")
                )); ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment by Insurance', Yii::app()->baseUrl . '/transaction/paymentIn/insuranceList', array(
                    'class' => 'button success right',
                    'style' => 'margin-right:10px',
                    'visible' => Yii::app()->user->checkAccess("paymentInCreate")
                )); ?>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                            'customerType' => $customerType,
                            'plateNumber' => $plateNumber,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'payment-in-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => NULL,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'payment_number',
                            'value' => 'CHtml::link($data->payment_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'payment_date',
                        array(
                            'name' => 'customer_name', 
                            'value' => 'empty($data->customer_id) ? "N/A" : $data->customer->name'
                        ),
                        'plate_number_list',
                        'invoice_number_list',
                        array(
                            'name' => 'payment_amount', 
                            'value' => 'AppHelper::formatMoney($data->totalPayment)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'header' => 'Insurance',
                            'value' => 'empty($data->insurance_company_id) ? "N/A" : $data->insuranceCompany->name',
                        ),
                        array(
                            'header' => 'Created By',
                            'name' => 'user_id',
                            'filter' => false,
                            'value' => 'empty($data->user_id) ? "N/A" : $data->user->username '
                        ),
                        array(
                            'header' => 'Approved By',
                            'value' => 'empty($data->paymentInApprovals) ? "N/A" : $data->paymentInApprovals[0]->supervisor->username '
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '$data->status'
                        ),
                        array(
                            'header' => 'Tanggal Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->created_datetime)'
                        ),
                    ),
                )); ?>
            </div>
            
            <fieldset>
                <legend>Pending Payment</legend>
                <div>
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Invoice Penjualan' => array(
                                'content' => $this->renderPartial('_viewPendingInvoice', array(
                                    'invoice' => $invoice,
                                    'invoiceDataProvider' => $invoiceDataProvider,
                                    'plateNumberInvoice' => $plateNumberInvoice,
                                ), true)
                            ),
                            'Downpayment' => array(
                                'content' => $this->renderPartial('_viewPendingDownpayment', array(
                                    'downpaymentDataProvider' => $downpaymentDataProvider,
                                    'registrationTransaction' => $registrationTransaction,
                                ), true)
                            ),
                            'Asuransi OR' => array(
                                'content' => $this->renderPartial('_viewPendingOwnRisk', array(
                                    'invoiceOwnRiskDataProvider' => $invoiceOwnRiskDataProvider,
                                    'saleInvoiceInsuranceOwnRisk' => $saleInvoiceInsuranceOwnRisk,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>