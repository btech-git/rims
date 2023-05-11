<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $saleRetailServiceSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($saleRetailServiceSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Jumlah per Halaman</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($service, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#service-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#service-dialog").dialog("open"); return false; }',
                                        )); ?>

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
                                                            $("#' . CHtml::activeId($service, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                            $("#service-dialog").dialog("close");
                                                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                                                $("#service_name").html("");
                                                            } else {
                                                                $.ajax({
                                                                    type: "POST",
                                                                    dataType: "JSON",
                                                                    url: "' . CController::createUrl('ajaxJsonService') . '",
                                                                    data: $("form").serialize(),
                                                                    success: function(data) {
                                                                        $("#service_name").html(data.service_name);
                                                                    },
                                                                });
                                                            }
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

                                        <?php echo CHtml::openTag('span', array('id' => 'service_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($service, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Mulai',
                                            ),
                                        )); ?>
                                    </div>

                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Sampai',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'saleRetailServiceSummary' => $saleRetailServiceSummary,
                        'service' => $service,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
            
<br/>

<div class="right">
    <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $saleRetailServiceSummary->dataProvider->pagination->itemCount,
        'pageSize' => $saleRetailServiceSummary->dataProvider->pagination->pageSize,
        'currentPage' => $saleRetailServiceSummary->dataProvider->pagination->getCurrentPage(false),
    ));*/ ?>
</div>
<div class="clear"></div>