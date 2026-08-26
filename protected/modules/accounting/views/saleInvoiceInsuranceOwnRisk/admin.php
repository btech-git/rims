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

<?php echo CHtml::beginForm(array(''), 'get'); ?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <!-- <a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/transaction/invoiceHeader/create'; ?>"><span class="fa fa-plus"></span>Create Invoice Headers</a> -->
                <h2>Manage Invoice OR</h2>
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
                                            <?php echo $form->label($model, 'transaction_number', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($model, 'transaction_number'); ?>
                                        </div>
                                    </div>
                                </div>	

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo $form->labelEx($model, 'transaction_date'); ?></label>
                                        </div>
                                        <div class="small-4 columns">
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'StartDate',
                                                'value' => $startDate,
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                    'changeMonth'=>true,
                                                    'changeYear'=>true,
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true,
                                                    'placeholder' => 'Mulai',
                                                ),
                                            )); ?>
                                        </div>

                                        <div class="small-4 columns">
                                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name' => 'EndDate',
                                                'value' => $endDate,
                                                'options' => array(
                                                    'dateFormat' => 'yy-mm-dd',
                                                    'changeMonth'=>true,
                                                    'changeYear'=>true,
                                                ),
                                                'htmlOptions' => array(
                                                    'readonly' => true,
                                                    'placeholder' => 'Sampai',
                                                ),
                                            )); ?>
                                        </div>
                                    </div>
                                </div>	

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo $form->label($model, 'customer_id', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">						
                                            <?php echo CHtml::textField('CustomerName', $customerName); ?>
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
                                            <?php echo CHtml::textField('PlateNumber', $plateNumber); ?>
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
            
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'invoice-own-risk-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'rowCssClassExpression' => '(($data->status == "PAID")?"hijau":"merah")',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'transaction_number', 
                            'value' => 'CHtml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        array(
                            'header' => 'Registration #', 
                            'value' => '$data->registrationTransaction->transaction_number',
                        ),
                        array(
                            'name' => 'customer_id', 
                            'value' => '$data->customer_id != null ? $data->customer->name : ""'
                        ),
                        array(
                            'name' => 'vehicle_id', 
                            'header' => 'Plat #',
                            'value' => '$data->vehicle_id != null ? $data->vehicle->plate_number : ""'
                        ),
                        array(
                            'header' => 'Kendaraan',
                            'value' => '$data->vehicle_id != null ? $data->vehicle->getCarMakeModelSubCombination() : ""'
                        ),
                        array(
                            'name' => 'insurance_company_id', 
                            'value' => '$data->insurance_company_id != null ? $data->insuranceCompany->name : ""'
                        ),
                        'status',
                    ),
                )); ?>
            </div>
            
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->

<?php echo CHtml::endForm(); ?>
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