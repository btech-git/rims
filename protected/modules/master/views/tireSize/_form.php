<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tire-size-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($tireSize->header); ?>

    <div class="row">
        <table>
            <thead>
                <tr>
                    <td><?php echo $form->labelEx($tireSize->header, 'section_width'); ?></td>
                    <td><?php echo $form->labelEx($tireSize->header, 'aspect_ratio'); ?></td>
                    <td><?php echo $form->labelEx($tireSize->header, 'construction_type'); ?></td>
                    <td><?php echo $form->labelEx($tireSize->header, 'rim_diameter'); ?></td>
                    <td><?php echo $form->labelEx($tireSize->header, 'load_rating'); ?></td>
                    <td><?php echo $form->labelEx($tireSize->header, 'speed_rating'); ?></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'section_width', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'section_width'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'aspect_ratio', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'aspect_ratio'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'construction_type', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'construction_type'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'rim_diameter', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'rim_diameter'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'load_rating', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'load_rating'); ?>
                    </td>
                    <td>
                        <?php echo $form->textField($tireSize->header, 'speed_rating', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($tireSize->header, 'speed_rating'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr /> 
    
    <div class="row">
        <?php echo CHtml::button('+ Car Model', array(
            'id' => 'car-model-button',
            'name' => 'CarModel',
            'onclick' => '$("#car-model-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#car-model-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('SaleInvoiceId'); ?>
    </div>

    <br />
    
    <div id="car_model_div">
        <?php $this->renderPartial('_detailCarModel', array('tireSize' => $tireSize)); ?>
    </div>
	
    <hr /> 
    
    <div class="row">
        <?php echo CHtml::button('+ Premium Option', array(
            'id' => 'premium-option-button',
            'name' => 'PremiumOption',
            'onclick' => '$("#premium-option-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#premium-option-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('SubBrandSeriesPremiumId'); ?>
    </div>

    <br />
    
    <div id="premium_option_div">
        <?php $this->renderPartial('_detailPremiumOption', array('tireSize' => $tireSize)); ?>
    </div>
	
    <hr /> 
    
    <div class="row">
        <?php echo CHtml::button('+ Standard Option', array(
            'id' => 'standard-option-button',
            'name' => 'StandardOption',
            'onclick' => '$("#standard-option-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#standard-option-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('SubBrandSeriesStandardId'); ?>
    </div>

    <br />
    
    <div id="standard_option_div">
        <?php $this->renderPartial('_detailStandardOption', array('tireSize' => $tireSize)); ?>
    </div>
	
    <hr /> 
    
    <div class="row">
        <?php echo CHtml::button('+ Economic Option', array(
            'id' => 'economic-option-button',
            'name' => 'EconomicOption',
            'onclick' => '$("#economic-option-dialog").dialog("open"); return false;', 
            'onkeypress' => 'if (event.keyCode == 13) { $("#economic-option-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('SubBrandSeriesEconomicId'); ?>
    </div>

    <br />
    
    <div id="economic_option_div">
        <?php $this->renderPartial('_detailEconomicOption', array('tireSize' => $tireSize)); ?>
    </div>
	
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'car-model-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Rekomendasi Kendaraan',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'car-model-grid',
    'dataProvider' => $carModelDataProvider,
    'filter' => $carModel,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'id' => 'CarModelIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'name' => 'car_make_id',
            'header' => 'Merk',
            'filter' => CHtml::activeDropDownList($carModel, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->carMake->name',
        ),
        array(
            'name' => 'name',
            'header' => 'Model',
            'value' => '$data->name',
        ),
        'description',
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Car Model', CController::createUrl('ajaxHtmlAddCarModels', array('id' => $tireSize->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#car_model_div").html(html);
        $("#car-model-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'premium-option-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Opsi Premium',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'premium-option-grid',
    'dataProvider' => $premiumOptionDataProvider,
    'filter' => $subBrandSeries,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'id' => 'SubBrandSeriesPremiumIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'header' => 'Brand',
            'filter' => CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->brand->name',
        ),
        array(
            'name' => 'sub_brand_id',
            'header' => 'Sub Brand',
            'filter' => CHtml::activeDropDownList($subBrandSeries, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->name',
        ),
        array(
            'name' => 'name',
            'header' => 'Sub Brand Series',
            'value' => '$data->name',
        ),
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Premium Option', CController::createUrl('ajaxHtmlAddPremiumOptions', array('id' => $tireSize->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#premium_option_div").html(html);
        $("#premium-option-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'standard-option-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Opsi Standar',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'standard-option-grid',
    'dataProvider' => $standardOptionDataProvider,
    'filter' => $subBrandSeries,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'id' => 'SubBrandSeriesStandardIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'header' => 'Brand',
            'filter' => CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->brand->name',
        ),
        array(
            'name' => 'sub_brand_id',
            'header' => 'Sub Brand',
            'filter' => CHtml::activeDropDownList($subBrandSeries, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->name',
        ),
        array(
            'name' => 'name',
            'header' => 'Sub Brand Series',
            'value' => '$data->name',
        ),
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Standard Option', CController::createUrl('ajaxHtmlAddStandardOptions', array('id' => $tireSize->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#standard_option_div").html(html);
        $("#standard-option-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'economic-option-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Opsi Ekonomis',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'economic-option-grid',
    'dataProvider' => $economicOptionDataProvider,
    'filter' => $subBrandSeries,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'id' => 'SubBrandSeriesEconomicIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'header' => 'Brand',
            'filter' => CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->brand->name',
        ),
        array(
            'name' => 'sub_brand_id',
            'header' => 'Sub Brand',
            'filter' => CHtml::activeDropDownList($subBrandSeries, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --')),
            'value' => '$data->subBrand->name',
        ),
        array(
            'name' => 'name',
            'header' => 'Sub Brand Series',
            'value' => '$data->name',
        ),
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Ekonomis Option', CController::createUrl('ajaxHtmlAddEconomicOptions', array('id' => $tireSize->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#economic_option_div").html(html);
        $("#economic-option-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
