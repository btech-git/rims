<?php
/* @var $this InsuranceCompanyController */
/* @var $model InsuranceCompany */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/insuranceCompany/admin'; ?>"><span class="fa fa-th-list"></span>Manage Insurance Company</a>
    <h1><?php if ($insurance->header->isNewRecord) {
    echo "New Insurance Company";
} else {
    echo "Update Insurance Company";
} ?></h1>
    <hr />

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'insurance-company-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'form'),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($insurance->header); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'name', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($insurance->header, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($insurance->header, 'name'); ?>
                    </div>
                </div>
            </div>

<!--            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php /*echo $form->labelEx($insurance->header, 'coa_id'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($insurance->header, 'coa_id'); ?>
                        <?php echo $form->textField($insurance->header, 'coa_name', array('readonly' => true, 'onclick' => 'jQuery("#coa-dialog").dialog("open"); return false;', 'value' => $insurance->header->coa_id != "" ? $insurance->header->coa->name : '')); ?>
                        <?php echo $form->textField($insurance->header, 'coa_code', array('readonly' => true, 'value' => $insurance->header->coa_id != "" ? $insurance->header->coa->code : '')); ?>
                        <?php echo $form->error($insurance->header, 'coa_id');*/ ?>
                    </div>
                </div>			
            </div>-->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'email', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($insurance->header, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($insurance->header, 'email'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'phone', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($insurance->header, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($insurance->header, 'phone'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'fax', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($insurance->header, 'fax', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($insurance->header, 'fax'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'npwp', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($insurance->header, 'npwp', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($insurance->header, 'npwp'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'address', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($insurance->header, 'address', array('rows' => 5, 'cols' => 50)); ?>
                        <?php echo $form->error($insurance->header, 'address'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'province_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($insurance->header, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'), array(
                            'prompt' => '[--Select Province--]',
                            'onchange' => 'jQuery.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxGetCity') . '" ,
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#InsuranceCompany_city_id").html(data);
                                },
                            });'
                        ));
                        ?>
                        <?php echo $form->error($insurance->header, 'province_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($insurance->header, 'city_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($insurance->header, 'city_id', $insurance->header->province_id != '' ? CHtml::listData(City::model()->findAllByAttributes(array('province_id' => $insurance->header->province_id)), 'id', 'name') : array(), array(
                            'prompt' => '[--Select City--]',
                        )); ?>
                        <?php echo $form->error($insurance->header, 'city_id'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::button('Add Price', array(
        'id' => 'price-button',
        'name' => 'price',
        'class' => 'button cbutton extra right',
        'onclick' => 'jQuery("#price-dialog").dialog("open"); return false;',
    )); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'price-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Service',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'price-grid',
        'dataProvider' => $serviceDataProvider,
        'filter' => $service,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
                $("#price-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddPriceDetail', array()) . '/id/' . $insurance->header->id . '/serviceId/"+$.fn.yiiGridView.getSelection(id),
                    data: $("form").serialize(),
                    success: function(html) {
                        $("#price").html(html);	
                    },
                });
                $("#price-grid").find("tr.selected").each(function(){
                $(this).removeClass( "selected" );
            });
        }',
        'columns' => array(
            array('name' => 'service_type_name', 'value' => '$data->serviceType->name'),
            array('name' => 'service_category_name', 'value' => '$data->serviceCategory->name'),
            'name'
        ),
    ));
    ?>
    <?php $this->endWidget(); ?>
    <div class="clearfix"></div>	 
    <div id="price" class="grid-view">
        <?php $this->renderPartial('_detailPrice', array('insurance' => $insurance)); ?>
    </div>
    
    <hr />

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($insurance->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
    </div>

    <?php $this->endWidget(); ?>
    <!--COA Supplier-->
    <?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
        'id' => 'coa-grid',
        'dataProvider' => $coaDataProvider,
        'filter' => $coa,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
                $("#coa-dialog").dialog("close");
                $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                        data: $("form").serialize(),
                        success: function(data) {

                                $("#InsuranceCompany_coa_id").val(data.id);
                                $("#InsuranceCompany_coa_code").val(data.code);
                                $("#InsuranceCompany_coa_name").val(data.name);

                        },
                });
                $("#coa-grid").find("tr.selected").each(function(){
                $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        array(
            'name',
            'code',
        ),
    ));
    ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');*/ ?>