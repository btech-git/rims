<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-purchase-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'branch_id', CHtml::listData(Branch::model()->findAll(),'id','name'), array('empty' => '-- Pilih Branch --')); ?>
                        <?php echo $form->error($model,'branch_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Category', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'asset_category_id', CHtml::listData(AssetCategory::model()->findAll(),'id','description'), array('empty' => '-- Pilih Category --')); ?>
                        <?php echo $form->error($model,'asset_category_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Transaction Date', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo $form->error($model,'transaction_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Item Description', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'description'); ?>
                        <?php echo $form->error($model,'description'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Harga Beli', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'purchase_value',array('size'=>18,'maxlength'=>18)); ?>
                        <?php echo $form->error($model,'purchase_value'); ?>
                    </div>
                </div>
            </div>    
        </div>
        
        <div class="small-12 medium-6 columns">
            <?php if ($model->isNewRecord): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Supplier', false); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($model, 'supplier_id', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
                            )); ?>
                            <?php echo $form->error($model,'supplier_id'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Company', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                        <?php echo CHtml::encode(CHtml::value($model, 'supplier.company')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Address', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                        <?php echo CHtml::encode(CHtml::value($model, 'supplier.address')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Note', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model,'note', array('rows' => 5, 'column' => 20)); ?>
                        <?php echo $form->error($model,'note'); ?>
                    </div>
                </div>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
            
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php if ($model->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'supplier-grid',
        'dataProvider' => $supplierDataProvider,
        'filter' => $supplier,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#' . CHtml::activeId($model, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#supplier-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#supplier_name").html("");
                $("#supplier_company").html("");
                $("#supplier_address").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $model->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#supplier_name").html(data.supplier_name);
                        $("#supplier_company").html(data.supplier_company);
                        $("#supplier_address").html(data.supplier_address); 
                    },
                });
            }
        }',
        'columns' => array(
            'name',
            'company',
            'address',
            'phone',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>