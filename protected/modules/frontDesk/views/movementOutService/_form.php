<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */
/* @var $form CActiveForm */
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <?php echo $form->errorSummary($movementOut->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <h2>Pengeluaran Bahan Pemakaian</h2>
                    <p class="note">Fields with <span class="required">*</span> are required.</p>

                    <hr />

                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($movementOut->header,'date_posting'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $movementOut->header,
                                            'attribute' => "date_posting",
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                                'yearRange' => '1900:2020'
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'value' => date('Y-m-d'),
                                            ),
                                        )); ?>
                                        <?php //echo $form->textField($movementOut->header,'date_posting',array('readonly'=>true)); ?>
                                        <?php echo $form->error($movementOut->header,'date_posting'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Repair Type'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.repair_type')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'WO #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.work_order_number')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Tanggal Registration'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.transaction_date')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END COLUMN 6-->
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($movementOut->header,'branch_id'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->textField($movementOut->header,'branch_name',array('value'=>$movementOut->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $movementOut->header->branch->name,'readonly'=>true)); ?>
                                        <?php echo $form->error($movementOut->header,'branch_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Registration Transaction #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationTransaction.transaction_number')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($movementOut->header,'user_id'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->hiddenField($movementOut->header,'user_id'); ?>
                                        <?php echo CHtml::encode($movementOut->header->user->username); ?>
                                        <?php echo $form->error($movementOut->header,'user_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Service Type'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.service_type')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    
                    <hr />
                    
                    <div class="row">
                        <div class="medium-12 columns">
                            <div>
                                <?php $this->renderPartial('_detailService', array(
                                    'movementOut' => $movementOut,
                                    'registrationTransaction' => $registrationTransaction,
                                )); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="medium-12 columns">
                            <div>
                                <?php $this->renderPartial('_detailProduct', array('movementOut' => $movementOut,)); ?>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
                        <?php echo CHtml::hiddenField('ProductId'); ?>
                    </div>

                    <br /><br />

                    <div class="row">
                        <div class="medium-12 columns">
                            <div id="detail_div">
                                <?php $this->renderPartial('_detail', array('movementOut' => $movementOut,)); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field buttons text-center">
                                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('myjavascript', '
        $(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
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
                            <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $(this).val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'name', array(
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_brand">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_master_category">
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $productDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id) {
                    $("#ProductId").val($.fn.yiiGridView.getSelection(id));
                    $("#product-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementOut->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) { $("#detail_div").html(html); },
                    });
                }',
                'columns' => array(
                    'name',
                    'manufacturer_code',
                    array(
                        'header' => 'Kategori',
                        'value' => '$data->masterSubCategoryCode'
                    ),
                    array(
                        'name' => 'product_brand_name',
                        'header' => 'Brand',
                        'value' => '$data->brand->name'
                    ),
                    array(
                        'name' => 'product_sub_brand_name',
                        'header' => 'Sub Brand',
                        'value' => 'empty($data->subBrand) ? "" : $data->subBrand->name'
                    ),
                    array(
                        'name' => 'product_sub_brand_series_name',
                        'header' => 'Sub Brand Series',
                        'value' => 'empty($data->subBrandSeries) ? "" : $data->subBrandSeries->name'
                    ),
                    array(
                        'name' => 'unit_id',
                        'header' => 'Unit',
                        'value' => '$data->unit->name'
                    ),
                ),
            ));	?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>