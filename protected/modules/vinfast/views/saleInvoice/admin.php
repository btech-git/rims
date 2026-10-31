<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    'Manage',
);

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

$('#invoiceSearch').submit(function(){
    $('#invoice-header-grid').yiiGridView('update', {
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
                <!--<a class="button warning right" href="<?php // echo Yii::app()->baseUrl.'/transaction/invoiceHeader/index'; ?>">Invoice Belum Terkirim</a>-->
                <h2>Manage Invoices</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <div class="form">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                            'id' => 'invoiceSearch',
                        )); ?>

                        <div class="row">
                            <div class="medium-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo $form->label($model, 'invoice_number', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($model, 'invoice_number'); ?>
                                        </div>
                                    </div>
                                </div>	

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($model, 'invoice_date'); ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <div class="row">
                                                <div class="medium-5 columns">
                                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                        'model' => $model,
                                                        'attribute' => "invoice_date",
                                                        // additional javascript options for the date picker plugin
                                                        'options' => array(
                                                            'dateFormat' => 'yy-mm-dd',
                                                        //'changeMonth'=>true,
                                                        // 'changeYear'=>true,
                                                        // 'yearRange'=>'1900:2020'
                                                        ),
                                                        'htmlOptions' => array(),
                                                    )); ?>
                                                    <?php echo $form->error($model, 'invoice_date'); ?>

                                                </div>
                                                <div class="medium-7 columns">
                                                    <div class="field">
                                                        <div class="row collapse">
                                                            <div class="small-4 columns">
                                                                <label class="prefix">To</label>
                                                            </div>
                                                            <div class="small-8 columns">
                                                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                    'model' => $model,
                                                                    'attribute' => "invoice_date_to",
                                                                    // additional javascript options for the date picker plugin
                                                                    'options' => array(
                                                                        'dateFormat' => 'yy-mm-dd',
                                                                    //             'changeMonth'=>true,
                                                                    // 'changeYear'=>true,
                                                                    // 'yearRange'=>'1900:2020'
                                                                    ),
                                                                    'htmlOptions' => array(),
                                                                )); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>	

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo CHtml::label('Customer', '', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropdownList($model, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                                                'condition' => 't.id IN (60849, 60926, 63482)',
                                                'order' => 't.name ASC'
                                            )), 'id', 'name'), array(
                                                'empty' => '-- All --',
                                            )); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="medium-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo CHtml::label('Plat #', '', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">						
                                            <?php echo CHtml::activeTextField($model, 'plate_number'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo $form->label($model, 'status', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">						
                                            <?php echo $form->dropDownList($model, 'status', array(
                                                'PARTIALLY PAID' => 'PARTIALLY PAID',
                                                'INVOICING' => 'INVOICING',
                                                'PAID' => 'PAID', 
                                                'CANCELLED!!!' => 'CANCEL',
                                            ), array('prompt' => '-- All --',)); ?>
                                        </div>
                                    </div>
                                </div>	

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo $form->label($model, 'branch_id', array('class' => 'prefix')); ?>
                                        </div>

                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                                        </div>
                                    </div>
                                </div>	
                                
                                <div class="buttons text-right">
                                    <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
                                </div>

                            </div>
                        </div>

                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
            
            <br /> 
            
            <?php echo CHtml::beginForm(); ?>
            <div>
                <?php echo CHtml::submitButton('Export to Excel', array(
                    'name' => 'SaveExcel',
                    'class' => 'button success'
                )); ?>
            </div>
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'invoice-header-grid',
                    'dataProvider' => $invoiceDataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'rowCssClassExpression' => '(($data->status == "PAID")?"hijau":"merah")',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 2,
                            'id' => 'SelectedIds',
                        ),
                        array(
                            'name' => 'invoice_number', 
                            'value' => 'CHtml::link($data->invoice_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'invoice_date',
                        'due_date',
                        array(
                            'name' => 'customer_id', 
                            'value' => '$data->customer_id != null ? $data->customer->name : ""'
                        ),
                        array(
                            'header' => 'Plat #', 
                            'value' => '$data->vehicle->plate_number',
                        ),
                        array(
                            'header' => 'Kendaraan', 
                            'value' => '$data->vehicle->carMakeModelSubCombination',
                        ),
                        array(
                            'name' => 'sales_order_id', 
                            'value' => '$data->sales_order_id != null ? $data->salesOrder->sale_order_no : CHtml::link($data->registrationTransaction->sales_order_number, array("/vinfast/saleRegistration/view", "id"=>$data->registration_transaction_id))',
                            'type' => 'raw'
                        ),
                        array(
                            'header' => 'WO #', 
                            'value' => '$data->sales_order_id != null ? "" : CHtml::link($data->registrationTransaction->work_order_number, array("/vinfast/saleRegistration/view", "id"=>$data->registration_transaction_id))',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'SPK #', 
                            'value' => '$data->sales_order_id != null ? "" : $data->registrationTransaction->customer_work_order_number',
                        ),
                        array(
                            'name' => 'transaction_tax_number',
                            'header' => 'F. Pajak #', 
                            'value' => '$data->transaction_tax_number',
                        ),
                        'status',
                    ),
                )); ?>
            </div>
            
            <?php echo CHtml::endForm(); ?>
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