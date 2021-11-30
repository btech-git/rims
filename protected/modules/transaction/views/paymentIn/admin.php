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
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                            'customerType' => $customerType,
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
                            'name' => 'invoice_id', 
                            'value' => '$data->invoice->invoice_number'
                        ),
                        array(
                            'name' => 'customer_name', 
                            'value' => '$data->customer->name'
                        ),
                        array(
                            'header' => 'Plate #', 
                            'value' => 'empty($data->invoice_id) ? "N/A" : $data->invoice->vehicle->plate_number'
                        ),
                        array(
                            'name' => 'payment_number',
                            'value' => 'CHTml::link($data->payment_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'payment_date',
                        array(
                            'name' => 'payment_amount', 
                            'value' => 'AppHelper::formatMoney($data->payment_amount)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        'notes',
                        array(
                            'header' => 'Invoice Status',
                            'name' => 'invoice_status',
                            'value' => '$data->invoice->status',
                        ),
                        array(
                            'header' => 'Type',
                            'value' => '$data->invoice->referenceTypeLiteral',
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
                    ),
                )); ?>
            </div>
            
            <fieldset>
                <legend>Pending Invoice</legend>
                <div class="grid-view">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'invoice-grid',
                        // 'dataProvider'=>$vehicleDataProvider,
                        'dataProvider' => $invoiceDataProvider,
                        'filter' => $invoice,
                        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                        'pager' => array(
                            'cssFile' => false,
                            'header' => '',
                        ),
                        'columns' => array(
                            array(
                                'name' => 'invoice_number',
                                'value' => 'CHTml::link($data->invoice_number, array("invoiceHeader/view", "id"=>$data->id))',
                                'type' => 'raw'
                            ),
                            'invoice_date',
                            'due_date',
                            'status',
                            array(
                                'name' => 'reference_type',
                                'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'
                            ),
                            array(
                                'name' => 'customer_name', 
                                'value' => '$data->customer->name'
                            ),
                            array(
                                'header' => 'Plate #', 
                                'value' => 'empty($data->vehicle_id) ? "N/A" : $data->vehicle->plate_number'
                            ),
                            array(
                                'name' => 'user_id',
                                'filter' => CHtml::activeDropDownList($invoice, 'user_id', CHtml::listData(Users::model()->findAll(array('order' => 'username')), 'id', 'username'), array('empty' => '-- all --')),
                                'header' => 'Created By',
                                'value' => 'empty($data->user_id) ? "N/A" : $data->user->username',
                            ),
                            array(
                                'name' => 'branch_id',
                                'header' => 'Branch',
                                'filter' => CHtml::activeDropDownList($invoice, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --')),
                                'value' => '$data->branch->name',
                            ),
                            array(
                                'name' => 'total_price', 
                                'value' => 'AppHelper::formatMoney($data->total_price)',
                                'htmlOptions' => array('style' => 'text-align: right'),
                            ),
                            array(
                                'header' => '',
                                'type' => 'raw',
                                'value' => 'CHtml::link("Create", array("create", "invoiceId"=>$data->id))',
                                'htmlOptions' => array(
                                    'style' => 'text-align: center;'
                                ),
                            ),
                        ),
                    )); ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
