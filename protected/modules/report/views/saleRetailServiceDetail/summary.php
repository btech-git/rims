<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
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
                                        <span class="prefix">Service Type</span>
                                    </div>
                                    <div class="small-8 columns">	
                                        <?php echo CHtml::dropDownList('ServiceTypeId', $serviceTypeId, CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                            'empty' => '-- All --',
                                            'onchange' => CHtml::ajax(array(
                                                'type' => 'GET',
                                                'url' => CController::createUrl('ajaxHtmlUpdateServiceCategorySelect'),
                                                'update' => '#service_category',
                                            )),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Category</span>
                                    </div>
                                    <div class="small-8 columns" id="service_category">
                                        <?php echo CHtml::dropDownList('ServiceCategoryId', $serviceCategoryId, CHtml::listData(ServiceCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
<!--                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Code</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php /*echo CHtml::activeTextField($service, 'code', array(
                                            'onchange' => '
                                            $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                                service_category_id: $("#Service_service_category_id").val(),
                                                service_type_id: $("#Service_service_type_id").val(),
                                                code: $(this).val(),
                                                name: $("#Service_name").val(),
                                            } } });',
                                        ));*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Name</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($service, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#service-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#service-dialog").dialog("open"); return false; }',
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'service-dialog',
                                            // additional javascript options for the dialog plugin
                                            'options' => array(
                                                'title' => 'Service',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )); ?>

                                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'service-grid',
                                            'dataProvider' => $serviceDataProvider,
                                            'filter' => $service,
                                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                            'pager'=>array(
                                               'cssFile'=>false,
                                               'header'=>'',
                                            ),
                                            'selectionChanged' => 'js:function(id){
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
                                            'columns' => array(
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
                                        <?php $this->endWidget(); ?>
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
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                     <div class="small-8 columns">
                                          <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
<!--                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php /*echo CHtml::activeTextField($service, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#service-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#service-dialog").dialog("open"); return false; }',
                                        )); ?>

                                         Service Dialog and Grid 
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
                                        <?php echo CHtml::closeTag('span');*/ ?> 

                                    </div>
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-4 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
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
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
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
                        'branchId' => $branchId,
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