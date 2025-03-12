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
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'invoice-header-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'id' => 'selectedIds',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '50',
                        ),
                        array(
                            'name' => 'invoice_number', 
                            'value' => 'CHtml::link($data->invoice_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'invoice_date',
                        array(
                            'name' => 'vehicle_id',
                            'header' => 'Plat #',
                            'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number',
                        ),
                        array(
                            'name' => 'customer_id', 
                            'value' => '$data->customer_id != null ? $data->customer->name : ""'
                        ),
                        array(
                            'name' => 'customer_type', 
                            'value' => '$data->customer_id != null ? $data->customer->customer_type : ""'
                        ),
                        array(
                            'name' => 'insurance_company_id', 
                            'value' => '$data->insurance_company_id != null ? $data->insuranceCompany->name : ""'
                        ),
                        array(
                            'name' => 'total_price', 
                            'value' => 'number_format($data->total_price, 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        'status',
                    ),
                )); ?>
                <?php echo CHtml::submitButton('Export E-Faktur (XML)', array('name' => 'SaveXml', 'style' => 'float: left;', 'class' => 'grey-btn')); ?>
                <?php echo CHtml::endForm(); ?>

            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->