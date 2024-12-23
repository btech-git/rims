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
                <!-- <a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/transaction/invoiceHeader/create'; ?>"><span class="fa fa-plus"></span>Create Invoice Headers</a> -->
                <h2>Manage Invoice Headers</h2>
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
                                            <?php echo $form->label($model, 'customer_name', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($model, 'customer_name'); ?>
                                        </div>
                                    </div>
                                </div>	
                                
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo $form->label($model, 'customer_type', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->dropDownList($model, 'customer_type', array('Individual' => 'Individual', 'Company' => 'Company',), array('prompt' => 'Select',)); ?>
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
                                            <?php echo CHtml::label('Insurance', '', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeDropDownList($model, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                                'empty' => '-- all --',
                                            )); ?>
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
                                            ), array('prompt' => 'Select',)); ?>
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

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'invoice-header-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'rowCssClassExpression' => '(($data->status == "PAID")?"hijau":"merah")',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
//                        array(
//                            'class' => 'CCheckBoxColumn', //CHECKBOX COLUMN ADDED.
//                            'selectableRows' => 2, //MULTIPLE ROWS CAN BE SELECTED.
//                            'checked' => function($data) use($prChecked) {
//                                return in_array($data->id, $prChecked);
//                            },
//                        ),
                        array(
                            'name' => 'invoice_number', 
                            'value' => 'CHtml::link($data->invoice_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'invoice_date',
                        'due_date',
                        array(
                            'name' => 'reference_type', 
                            'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'
                        ),
                        array(
                            'name' => 'sales_order_id', 
                            'value' => '$data->sales_order_id != null ? $data->salesOrder->sale_order_no : CHtml::link($data->registrationTransaction->sales_order_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->registration_transaction_id))',
                            'type' => 'raw'
                        ),
                        array(
                            'header' => 'WO #', 
                            'value' => '$data->sales_order_id != null ? "" : $data->registrationTransaction->work_order_number'
                        ),
                        array(
                            'name' => 'customer_id', 
                            'value' => '$data->customer_id != null ? $data->customer->name : ""'
                        ),
                        array(
                            'name' => 'customer_type', 
                            'value' => '$data->customer_id != null ? $data->customer->customer_type : ""'
                        ),
                        'status',
                    ),
                )); ?>

<!--                <div class="button-group">
                    <?php /*if (Yii::app()->user->checkAccess("saleInvoiceEdit")): ?>
                        <?php echo CHtml::button("View Invoice", array("id" => "btnProses", 'class' => 'button cbutton')); ?>
                    <?php endif; ?>
                    <?php if (Yii::app()->user->checkAccess("saleInvoiceEdit")): ?>
                        <?php echo CHtml::button("Export PDF", array("id" => "btnProsesPdf", 'class' => 'button cbutton')); ?>
                    <?php endif; ?>

                    <?php echo CHtml::button("Clear Selected", array("id" => "btnClear", 'class' => 'button cbutton'));*/ ?>
                </div>-->
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->

<?php Yii::app()->clientScript->registerScript('centang', '
	$("#btnProses").click(function(){
        var checked=$("#invoice-header-grid").yiiGridView("getChecked","invoice-header-grid_c0");
        var count=checked.length;
        if (count>0){
            $.ajax({
                    data:{checked:checked},
                    url:"' . CHtml::normalizeUrl(array('invoiceHeader/prTemp')) . '",
                    success:function(data){
                    	$("#invoice-header-grid").yiiGridView("update",{});
                    	window.location.href = "' . CHtml::normalizeUrl(array('invoiceHeader/viewInvoices')) . '";
                    },              
            });
        } else {
            console.log("No Invoice items selected");
            alert("No Invoice items selected");
        }
    });

    $("#btnProsesPdf").click(function(){
        var checked=$("#invoice-header-grid").yiiGridView("getChecked","invoice-header-grid_c0");
        var count=checked.length;
        if (count > 0){
            $.ajax({
                data:{checked:checked},
                url:"' . CHtml::normalizeUrl(array('invoiceHeader/prTemp')) . '",
                success:function(data){
                    $("#invoice-header-grid").yiiGridView("update",{});
                    window.location.href = "' . CHtml::normalizeUrl(array('invoiceHeader/pdfAll')) . '";
                },              
            });
        } else {
            console.log("No Invoice items selected");
            alert("No Invoice items selected");
        }
    });

    $("#btnClear").click(function(){
        var checked="clear";
        $.ajax({
            data:{checked:checked},
            url:"' . CHtml::normalizeUrl(array('invoiceHeader/prTemp')) . '",
            success:function(data){
                $("#invoice-header-grid").yiiGridView("update",{});
            },              
        });
    });
'); ?>

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