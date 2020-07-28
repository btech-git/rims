<?php
/* @var $this SupplierController */
/* @var $model Supplier */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/supplier/admin';?>"><span class="fa fa-th-list"></span>Manage Supplier</a>
    <h1><?php if ($supplier->header->isNewRecord){ echo "New Supplier"; }else{ echo "Update Supplier";}?></h1>
    <!-- begin FORM -->
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'supplier-form',
            'enableAjaxValidation'=>false,
        )); ?>
        
        <hr />
        
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($supplier->header); ?>
        <?php echo $form->errorSummary($supplier->bankDetails); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'code'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'code',array('size'=>20,'maxlength'=>20)); ?>
                            <?php echo $form->error($supplier->header,'code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'name',array('size'=>30,'maxlength'=>30,'style'=>'text-transform: capitalize')); ?>
                            <?php echo $form->error($supplier->header,'name'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'company'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'company',array('size'=>30,'maxlength'=>30)); ?>
                            <?php echo $form->error($supplier->header,'company'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'address'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($supplier->header,'address', array('rows'=>3, 'cols'=>50)); ?>
                            <?php echo $form->error($supplier->header,'address'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'province_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($supplier->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
                                'prompt' => '[--Select Province--]',
                                'onchange'=> '$.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxGetCity') . '" ,
                                    data: $("form").serialize(),
                                    success: function(data){
                                        console.log(data);
                                        $("#Supplier_city_id").html(data);
                                    },
                                });'
                            )); ?>
                            <?php echo $form->error($supplier->header,'province_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                          <label class="prefix"><?php echo $form->labelEx($supplier->header,'city_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo  $form->dropDownList($supplier->header, 'city_id',	 array('prompt' => 'Select',)); ?>
                            <?php //echo $form->textField($supplier->header,'city_id',array('size'=>10,'maxlength'=>10)); ?>
                            <?php
                                if ($supplier->header->province_id == NULL) {
                                    echo $form->dropDownList($supplier->header,'city_id',array(),array('prompt'=>'[--Select City-]'));
                                } else {
                                    echo $form->dropDownList($supplier->header,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$supplier->header->province_id)), 'id', 'name'),array());
                                }
                            ?>
                            <?php echo $form->error($supplier->header,'city_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'zipcode'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
                            <?php echo $form->error($supplier->header,'zipcode'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'email_personal'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'email_personal'); ?>
                            <?php echo $form->error($supplier->header,'email_personal'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'email_company'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'email_company',array('size'=>60,'maxlength'=>60)); ?>
                            <?php echo $form->error($supplier->header,'email_company'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'npwp'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'npwp',array('size'=>20,'maxlength'=>20)); ?>
                            <?php echo $form->error($supplier->header,'npwp'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'tenor'); ?></label>
                        </div>
                        <div class="small-3 columns">
                            <?php $range = range(10,100,5 ); ?>
                            <?php echo $form->dropDownList($supplier->header,'tenor',array_combine($range, $range )); ?>
                            <?php echo $form->error($supplier->header,'tenor'); ?>
                        </div>
                        <div class="small-5 columns"><label class="sufix"><?php echo 'days' ?></label></div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'coa_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($supplier->header,'coa_id'); ?>
                            <?php echo $form->textField($supplier->header,'coa_name',array('readonly'=>true,'value'=>$supplier->header->coa_id != "" ? Coa::model()->findByPk($supplier->header->coa_id)->name : '','onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;')); ?>
                            <?php echo $form->textField($supplier->header,'coa_code',array('readonly'=>true,'value'=>$supplier->header->coa_id != "" ? Coa::model()->findByPk($supplier->header->coa_id)->code : '')); ?>
                            <?php echo $form->error($supplier->header,'coa_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'coa_outstanding_order'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($supplier->header,'coa_outstanding_order'); ?>
                            <?php echo $form->textField($supplier->header,'coa_outstanding_name',array('readonly'=>true,'value'=>$supplier->header->coa_outstanding_order != "" ? Coa::model()->findByPk($supplier->header->coa_outstanding_order)->name : '','onclick'=>'jQuery("#coa-outstanding-dialog").dialog("open"); return false;')); ?>
                            <?php echo $form->textField($supplier->header,'coa_outstanding_code',array('readonly'=>true,'value'=>$supplier->header->coa_outstanding_order != "" ? Coa::model()->findByPk($supplier->header->coa_outstanding_order)->code : '')); ?>
                            <?php echo $form->error($supplier->header,'coa_outstanding_order'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'phone'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'phone',array('size'=>10,'maxlength'=>60)); ?>
                            <?php echo $form->error($supplier->header,'phone'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'mobile_phone'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'mobile_phone',array('size'=>50,'maxlength'=>100)); ?>
                            <?php echo $form->error($supplier->header,'mobile_phone'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'person_in_charge'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($supplier->header,'person_in_charge',array('size'=>10,'maxlength'=>100)); ?>
                            <?php echo $form->error($supplier->header,'person_in_charge'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'company_attribute'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo  $form->dropDownList($supplier->header, 'company_attribute', array(
                                'PKP' => 'PKP',
                                'NonPKP' => 'NonPKP',
                            ),array('prompt'=>'[-- Select Company Attribute --]')); ?>
                            <?php echo $form->error($supplier->header,'company_attribute'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'description'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($supplier->header,'description', array('rows'=>5, 'cols'=>50)); ?>
                            <?php echo $form->error($supplier->header,'description'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($supplier->header,'status'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($supplier->header, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive')); ?>
                            <?php echo $form->error($supplier->header,'status'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Banks</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::button('+', array(
                            'id' => 'detail-bank-button',
                            'name' => 'DetailBanks',
                            'onclick' => 'jQuery("#bank-dialog").dialog("open"); return false;'
                        )); ?>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'bank-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Bank',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'bank-grid',
                            'dataProvider'=>$bankDataProvider,
                            'filter'=>$bank,
                            // 'summaryText'=>'',
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged'=>'js:function(id) {
                                $("#bank-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('supplier/ajaxHtmlAddBankDetail', array('id'=>$supplier->header->id,'bankId'=>'')). '"+$.fn.yiiGridView.getSelection(id),
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#bank").html(html);
                                    },
                                });
                                $("#bank-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'columns'=>array(
                                'code',
                                'name'
                            ),
                        )); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
            <div class="field" id="bank">
                <div class="row collapse">
                    <?php $this->renderPartial('_detailBank', array('supplier'=>$supplier)); ?>
                </div>
            </div>
        </div>

        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($supplier->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>
</div><!-- form -->
<!--COA Supplier-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'coa-grid',
        'dataProvider'=>$coaDataProvider,
        'filter'=>$coa,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'selectionChanged'=>'js:function(id){
            $("#coa-dialog").dialog("close");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {

                    $("#Supplier_coa_id").val(data.id);
                    $("#Supplier_coa_code").val(data.code);
                    $("#Supplier_coa_name").val(data.name);

                },
            });
            $("#coa-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
        }',
        'columns'=> array(
            'name',
            'code',
        ),
    )); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--COA Outstanding Supplier-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-outstanding-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA Outstanding Order',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-outstanding-grid',
		'dataProvider'=>$coaOutstandingDataProvider,
		'filter'=>$coaOutstanding,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#coa-outstanding-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					$("#Supplier_coa_outstanding_order").val(data.id);
					$("#Supplier_coa_outstanding_code").val(data.code);
					$("#Supplier_coa_outstanding_name").val(data.name);
				},
			});
			$("#coa-outstanding-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=> array(
			'name',
			'code',
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>