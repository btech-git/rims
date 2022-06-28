<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'General Repair Registration'=>array('admin'),
	'Add Product Service',
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage General Repair Registration</a>
        <h1><?php if($generalRepairRegistration->header->isNewRecord){ echo "New General Repair Registration"; }else{ echo "Update General Repair Registration";}?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($generalRepairRegistration->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                            'tabs' => array(
                                'Customer Info' => array(
                                    'id' => 'info1',
                                    'content' => $this->renderPartial('_infoCustomer', array(
                                        'generalRepairRegistration' => $generalRepairRegistration, 
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                                'Service Exception Rate' => array(
                                    'id' => 'info3',
                                    'content' => $this->renderPartial('_serviceException', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'History' => array(
                                    'id' => 'info4',
                                    'content' => $this->renderPartial('_historyTransaction', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'vehicle' => $vehicle,
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
                    <!-- END ROW -->
                    <br />

                    <div class="row">
                        <div class="medium-12 columns">
                            <h2>Transaction</h2>
                            <hr />
                            <table>
                                <thead>
                                    <tr>
                                        <th>Transaction #</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Car Mileage (KM)</th>
                                        <th>Branch</th>
                                        <th>User</th>
                                        <th>PPn</th>
                                        <th>PPh</th>
                                        <?php if($generalRepairRegistration->header->work_order_number != ""): ?>
                                            <th>WO #</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'transaction_number')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'transaction_date')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'repair_type')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'vehicle_mileage')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'branch.name')); ?></td>
                                        <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'user.username')); ?></td>
                                        <td>
                                            <?php echo CHtml::activeCheckBox($generalRepairRegistration->header,'ppn', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $generalRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_item_amount").html(data.taxItemAmount);
                                                    }',
                                                )),
                                            )); ?>
                                            <?php echo CHtml::activeDropDownList($generalRepairRegistration->header, 'tax_percentage', array(
                                                0 => 0,
                                                10 => 10,
                                                11 => 11,
                                            ), array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $generalRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_item_amount").html(data.taxItemAmount);
                                                    }',
                                                )),
                                            )); ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::activeCheckBox($generalRepairRegistration->header,'pph', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $generalRepairRegistration->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_service_amount").html(data.taxServiceAmount);
                                                        $("#total_quick_service_quantity").html(data.totalQuickServiceQuantity);
                                                        $("#sub_total_quick_service").html(data.subTotalQuickService);
                                                    }',
                                                )),
                                            )); ?>
                                        </td>
                                        <?php if ($generalRepairRegistration->header->work_order_number != ""): ?>
                                            <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'work_order_number')); ?></td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="medium-12 columns">
                                <div class="detail">                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-2 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'problem'); ?></label>
                                            </div>
                                            <div class="small-10 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'problem')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                            </div>
                            
                            <div class="row">
                                <div class="medium-6 columns">
                                    <div id="detailQs">
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <?php echo CHtml::activeCheckBox($generalRepairRegistration->header,'is_quick_service',array(
                                                        1 => 1,
                                                        'disabled' => $generalRepairRegistration->header->is_quick_service == 1 ? false : true, 
                                                        'onchange' => '
                                                        if($("#RegistrationTransaction_is_quick_service").is(":checked"))
                                                        {
                                                            $("#detail-button").prop("disabled",false);
                                                        }
                                                        else{
                                                            $("#detail-button").prop("disabled",true);
                                                            $.ajax({
                                                                type: "POST",
                                                                //dataType: "JSON",
                                                                url: "' . CController::createUrl('ajaxHtmlRemoveQuickServiceDetailAll', array('id'=> $generalRepairRegistration->header->id)).'",
                                                                data: $("form").serialize(),
                                                                success: function(html) {
                                                                    $("#quickService").html(html);	

                                                                },
                                                            });
                                                        }'
                                                    )); ?>
                                                    <label for="is_quick_service">Quick Service</label>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::button('add Quick Service', array(
                                                        'id' => 'detail-button',
                                                        'name' => 'Detail',
                                                        // 'class'=>'button extra left',
                                                        'disabled'=>$generalRepairRegistration->header->is_quick_service == 1 ? false : true,
                                                        'onclick' => '
                                                        jQuery("#qs-dialog").dialog("open"); return false;'
                                                    )); ?>
                                                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                                        'id' => 'qs-dialog',
                                                        'options' => array(
                                                            'title' => 'Quick Service',
                                                            'autoOpen' => false,
                                                            'width' => 'auto',
                                                            'modal' => true,
                                                        ),
                                                    )); ?>
                                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                                        'id'=>'qs-grid',
                                                        'dataProvider'=>$qsDataProvider,
                                                        'filter'=>$qs,
                                                        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                                        'pager'=>array(
                                                            'cssFile'=>false,
                                                            'header'=>'',
                                                        ),
                                                        'selectionChanged'=>'js:function(id){
                                                            $("#qs-dialog").dialog("close");
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "' . CController::createUrl('ajaxHtmlAddQuickServiceDetail', array('id'=>$generalRepairRegistration->header->id,'quickServiceId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
                                                                data: $("form").serialize(),
                                                                success: function(html) {
                                                                    $("#quickService").html(html);
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        dataType: "JSON",
                                                                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $generalRepairRegistration->header->id)). '",
                                                                        data: $("form").serialize(),
                                                                        success: function(data) {
                                                                            $("#grand_total_transaction").html(data.grandTotal);
                                                                            $("#total_quick_service_quantity").html(data.totalQuickServiceQuantity);
                                                                            $("#sub_total_quick_service").html(data.subTotalQuickService);
                                                                        },
                                                                    });

                                                                },
                                                            });
                                                            $("#qs-grid").find("tr.selected").each(function(){
                                                                $(this).removeClass( "selected" );
                                                            });
                                                        }',
                                                        'columns'=>array(
                                                            'code',
                                                            'name',
                                                            'rate',
                                                            array(
                                                                'name'=>'rate',
                                                                'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->rate)',
                                                            ),
                                                        ),
                                                    )); ?>
                                                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <!-- end of DetailQs -->
                                </div>

                                <hr />
                                <!-- DETAIL QUICK SERVICE -->
                                <div class="medium-12 columns">
                                    <div class="detail">
                                        <div class="field" id="quickService">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailQuickService', array('generalRepairRegistration'=>$generalRepairRegistration)); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>								
                                </div>
                                <!-- END QUICK SERVICE -->
                            </div>

                            <div class="row">
                                <div class="medium-12 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Service</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::button('add Service', array(
                                                    'id' => 'service-detail-button',
                                                    'name' => 'service-detail',
                                                    // 'class'=>'button extra left',
                                                    //'disabled'=>'false',
                                                    'onclick' => 'jQuery("#service-dialog").dialog("open"); return false;'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail">
                                        <div class="field" id="service">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailService', array('generalRepairRegistration'=>$generalRepairRegistration)); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Product</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::button('add Product', array(
                                                    'id' => 'product-detail-button',
                                                    'name' => 'product-detail',
                                                    'onclick' => 'jQuery("#product-dialog").dialog("open"); return false;'
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail">
                                        <div class="field" id="product">
                                            <div class="row collapse">
                                                <div class="small-12 columns">
                                                    <?php $this->renderPartial('_detailProduct', array(
                                                        'generalRepairRegistration'=>$generalRepairRegistration,
                                                        'branches' => $branches,
                                                    )); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="field">
                                    <table>
                                        <tr>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_quickservice'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_quickservice',array('readonly'=>true)); ?>
                                                <span id="total_quick_service_quantity">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_quickservice'))); ?>                                                
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_quickservice'); ?>
                                            </td>
                                            <td colspan="4">&nbsp;</td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_quickservice_price'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_quickservice_price',array('size'=>18,'maxlength'=>18,'readonly'=>true, )); ?>
                                                <span id="sub_total_quick_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_quickservice_price'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_quickservice_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_service', array('readonly'=>true)); ?>
                                                <span id="total_quantity_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_service'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'subtotal_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'subtotal_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'subtotal_service'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'subtotal_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'discount_service'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'discount_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="total_discount_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'discount_service'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'discount_service'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_service_price'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_service_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="grand_total_service">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_service_price'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_service_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_product',array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?>
                                                <span id="total_quantity_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_product'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'subtotal_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'subtotal_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'subtotal_product'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'subtotal_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'discount_product'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'discount_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,'class'=>'numbers')); ?>
                                                <span id="total_discount_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'discount_product'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'discount_product'); ?>
                                            </td>
                                            <td><?php echo $form->labelEx($generalRepairRegistration->header,'total_product_price'); ?></td>
                                            <td style="text-align: right">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'total_product_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="grand_total_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'total_product_price'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'total_product_price'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($generalRepairRegistration->header,'subtotal'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'subtotal',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'subtotal'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'subtotal'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($generalRepairRegistration->header,'ppn_price'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'ppn_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_item_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'ppn_price'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'ppn_price'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($generalRepairRegistration->header,'pph_price'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'pph_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_service_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'pph_price'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'pph_price'); ?>
                                            </td>
                                            <td style="font-weight: bold"><?php echo $form->labelEx($generalRepairRegistration->header,'grand_total'); ?></td>
                                            <td style="text-align: right; font-weight: bold">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'grand_total',array('size'=>18,'maxlength'=>18,'readonly'=>true)); ?>
                                                <span id="grand_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($generalRepairRegistration->header,'grand_total'))); ?>
                                                </span>
                                                <?php echo $form->error($generalRepairRegistration->header,'grand_total'); ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="medium-12 columns">
                                    <div class="field buttons text-center">
                                        <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                                        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>

<!-- Service Dialog and Grid -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'service-dialog',
    'options' => array(
        'title' => 'Service',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <td>Kategori</td>
                        <td>Type</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'code', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $("#Service_service_category_id").val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $(this).val(),
                                    name: $("#Service_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($service, 'name', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $("#Service_service_category_id").val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $("#Service_code").val(),
                                    name: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                'onchange' => '
                                $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                    service_category_id: $(this).val(),
                                    service_type_id: $("#Service_service_type_id").val(),
                                    code: $("#Service_code").val(),
                                    name: $("#Service_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div>
                                <?php echo CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                    'onchange' => '
                                    $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                        service_category_id: $("#Service_service_category_id").val(),
                                        service_type_id: $(this).val(),
                                        code: $("#Service_code").val(),
                                        name: $("#Service_name").val(),
                                    } } });',
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'service-grid',
                'dataProvider'=>$serviceDataProvider,
                'filter'=>null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                    'cssFile'=>false,
                    'header'=>'',
                ),
                'selectionChanged'=>'js:function(id){
                    $("#service-dialog").dialog("close");
                    var vehicle = +$("#RegistrationTransaction_vehicle_id").val();
                    var repair = +$("#RegistrationTransaction_repair_type").val();
                    if((vehicle != "") && repair !=""){
                        $.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id'=> $generalRepairRegistration->header->id)).'&serviceId="+$.fn.yiiGridView.getSelection(id)+"&customerId="+ $("#RegistrationTransaction_customer_id").val()+"&custType="+$("#Customer_customer_type").val()+"&vehicleId="+$("#RegistrationTransaction_vehicle_id").val()+"&repair="+$("#RegistrationTransaction_repair_type").val(),
                            data: $("form").serialize(),
                            success: function(html) {
                                $("#service").html(html);
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $generalRepairRegistration->header->id)). '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#grand_total").html(data.grandTotal);
                                        $("#total_quantity_service").html(data.totalQuantityService);
                                        $("#sub_total_service").html(data.subTotalService);
                                        $("#total_discount_service").html(data.totalDiscountService);
                                        $("#grand_total_service").html(data.grandTotalService);
                                        $("#sub_total_transaction").html(data.subTotalTransaction);
                                        $("#tax_item_amount").html(data.taxItemAmount);
                                        $("#tax_service_amount").html(data.taxServiceAmount);
                                        $("#grand_total_transaction").html(data.grandTotal);
                                    },
                                });
                            },
                        });
                    }
                    else{
                        alert("Please Check if you had already choose Repair type and Vehicle.");
                    }

                    $("#service-grid").find("tr.selected").each(function(){
                        $(this).removeClass( "selected" );
                    });
                }',
                'columns'=>array(
                    'code',
                    'name',
                    array(
                        'name' => 'service_category_id',
                        'value' => '$data->serviceCategory->name',
                    ),
                    array(
                        'name' => 'service_type_id',
                        'value' => '$data->serviceType->name',
                    ),
                ),
            )); ?>
        </div>
    </div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    'options' => array(
        'title' => 'Product',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm(); ?>
<div class="row">
    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>Master Kategori</td>
                    <td>Sub Master Kategori</td>
                    <td>Sub Kategori</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'id', array(
                            'onchange' => '
                            $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                id: $(this).val(),
                                name: $("#Product_name").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                            'onchange' => '
                            $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $(this).val(),
                                id: $("#Product_id").val(),
                                name: $("#Product_name").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($product, 'name', array(
                            'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $(this).val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                'update' => '#product_sub_brand',
                            )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                brand_id: $(this).val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $("#Product_name").val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_brand">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                    'update' => '#product_sub_brand_series',
                                )),
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <div id="product_sub_brand_series">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                'update' => '#product_sub_master_category',
                            )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $(this).val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $("#Product_name").val(),
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_master_category">
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                    'update' => '#product_sub_category',
                                )),
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <div id="product_sub_category">
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                            )); ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'product-grid',
            'dataProvider'=>$productDataProvider,
            'filter'=>null,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
                'cssFile'=>false,
                'header'=>'',
            ),
            'selectionChanged'=>'js:function(id){
                $("#product-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id'=>$generalRepairRegistration->header->id,'productId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
                    data:$("form").serialize(),
                    success: function(html) {
                        $("#product").html(html);

                    },
                });
                $("#product-grid").find("tr.selected").each(function(){
                    $(this).removeClass( "selected" );
                });
            }',
            'columns'=>array(
                'id',
                'manufacturer_code',
                'name',
                array(
                    'name'=>'product_brand_name', 
                    'value'=>'empty($data->brand_id) ? "" : $data->brand->name'
                ),
                array(
                    'header' => 'Sub Brand', 
                    'name' => 'product_sub_brand_name', 
                    'value' => 'empty($data->sub_brand_id) ? "" : $data->subBrand->name'
                ),
                array(
                    'header' => 'Sub Brand Series', 
                    'name' => 'product_sub_brand_series_name', 
                    'value' => 'empty($data->sub_brand_series_id) ? "" : $data->subBrandSeries->name'
                ),
                'masterSubCategoryCode: Kategori',
                array(
                    'name'=>'unit_id', 
                    'value'=>'empty($data->unit_id) ? "" : $data->unit->name'
                ),
                array(
                    'name'=>'retail_price',
                    'header' => 'Price',
                    'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->retail_price)',
                ),
                'vehicleCarMake.name: Car',
            ),
        )); ?>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
	function ClearFields() {
		$('#pic').find('input:text').val('');
		$('#CustomerPic_address').val('');
	}
    
    if($("#RegistrationTransaction_repair_type").val() == "GR")
    {
<!--        $("#RegistrationTransaction_is_quick_service").prop("disabled",false);-->
        $("#RegistrationTransaction_is_insurance").prop("disabled",true);
        $("#damage-data-button").prop("disabled",true);
        $("#RegistrationTransaction_is_insurance").attr("checked", false);
        $("#RegistrationTransaction_insurance_company_id").val("");
        $("#RegistrationTransaction_insurance_company_id").prop("disabled",true);

    }
    else if($("#RegistrationTransaction_repair_type").val() == "BR")
    {
        $("#RegistrationTransaction_is_quick_service").prop("disabled",true);
        $("#RegistrationTransaction_is_insurance").prop("disabled",false);
        $("#damage-data-button").prop("disabled",false);
        $("#RegistrationTransaction_is_quick_service").attr("checked", false);
    }
    else
    {
<!--        $("#RegistrationTransaction_is_quick_service").prop("disabled",true);-->
        $("#RegistrationTransaction_is_insurance").prop("disabled",true);
        $("#damage-data-button").prop("disabled",true);
    }

</script>
<?php  Yii::app()->clientScript->registerScript('search',"
    $('#Service_findkeyword').keypress(function(e) {
            $.fn.yiiGridView.update('service-grid', {
                data: $(this).serialize()
            });
        if(e.which == 13) {
            return false;
        }
    });
    
"); ?>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>