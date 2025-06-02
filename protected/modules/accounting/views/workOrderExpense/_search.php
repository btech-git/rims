<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
		<!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transaction_number'); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'StartDate',
                                'attribute' => $startDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                        <div class="medium-2 columns" style="text-align: center; vertical-align: middle">
                            S/D
                        </div>
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'EndDate',
                                'attribute' => $endDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'supplier_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model, 'supplier_id', array(
                            'readonly' => true,
                            'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                            'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                        )); ?>

                        <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                        <?php echo CHtml::encode(CHtml::value($model, 'supplier.name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Plat #', '', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('PlateNumber', $plateNumber); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Customer', '', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('CustomerId', $customerId, array(
                            'readonly' => true,
                            'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                            'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                        )); ?>

                        <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                        <?php $customerData = Customer::model()->findByPk($customerId); ?>
                        <?php echo CHtml::encode(CHtml::value($customerData, 'name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>	

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div>

<div>
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
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonSupplier') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#supplier_name").html(data.supplier_name);
                    },
                });
            }
        }',
        'columns' => array(
            'name',
            'company',
            'address',
            'description',
            'status'
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'customer-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Customer',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'customer-grid',
        'dataProvider' => $customerDataProvider,
        'filter' => $customer,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#CustomerId").val($.fn.yiiGridView.getSelection(id));
            $("#customer-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#customer_name").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonCustomer') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#customer_name").html(data.customer_name);
                    },
                });
            }
        }',
        'columns' => array(
            'name',
            'mobile_phone',
            'email',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
