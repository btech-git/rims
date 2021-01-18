<?php
/* @var $this PaymentInController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Payment Ins',
);

$this->menu = array(
    array('label' => 'Create PaymentIn', 'url' => array('create')),
    array('label' => 'Manage PaymentIn', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-list" ></span>Manage Payment In', Yii::app()->baseUrl . '/transaction/paymentIn/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.admin"))) ?>
                <h2>NOT PAID Invoice List</h2>
            </div>
            
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
                            'filter' => CHtml::activeDropDownList($invoice, 'reference_type', array(
                                "1" => "Sales Order",
                                "2" => "Retail Sales",
                            ), array("empty" => "-- all --")),
                            'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"',
                        ),
                        array(
                            'name' => 'customer_name', 
                            'value' => '$data->customer->name',
                        ),
                        array(
                            'name' => 'total_price', 
                            'value' => 'AppHelper::formatMoney($data->total_price)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->





