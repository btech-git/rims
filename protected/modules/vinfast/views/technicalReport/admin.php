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

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <h2>Manage Technical Report</h2>
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
                                            <?php echo $form->label($model, 'document_number', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo $form->textField($model, 'document_number'); ?>
                                        </div>
                                    </div>
                                </div>	
                            </div>
                            
                            <div class="medium-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <?php echo CHtml::label('Warranty Claim #', '', array('class' => 'prefix')); ?>
                                        </div>
                                        <div class="small-8 columns">						
                                            <?php echo CHtml::activeTextField($model, 'warranty_claim_number'); ?>
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
            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'technical-report-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'document_number', 
                            'value' => 'CHtml::link($data->document_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw',
                        ),
                        'warranty_claim_number',
                        array(
                            'header' => 'Registration #', 
                            'value' => '$data->registration_product_id != null ? $data->registrationProduct->registrationTransaction->transaction_number : ""'
                        ),
                        array(
                            'header' => 'Part Name', 
                            'name' => 'main_part_name',
                            'value' => 'CHtml::encode(CHtml::value($data, "main_part_name"))'
                        ),
                        array(
                            'header' => 'Kendaraan', 
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationProduct.registrationTransaction.vehicle.carMakeModelSubCombination"))'
                        ),
                        array(
                            'header' => 'Plat #', 
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationProduct.registrationTransaction.vehicle.plate_number"))'
                        ),
                        array(
                            'header' => 'VIN #', 
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationProduct.registrationTransaction.vehicle.frame_number"))'
                        ),
                        array(
                            'header' => 'Mileage (KM)', 
                            'value' => 'CHtml::encode(CHtml::value($data, "registrationProduct.registrationTransaction.vehicle_mileage"))'
                        ),
                    ),
                )); ?>
            </div>
            
            <?php echo CHtml::endForm(); ?>
        </div>
    </div> <!-- end row -->
    
    <hr />
    
    <div class="row">
        <?php $this->renderPartial('_pending', array(
            'registrationTransaction' => $registrationTransaction,
            'pendingDataProvider' => $pendingDataProvider,
        )); ?>
    </div>
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
));?>,
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