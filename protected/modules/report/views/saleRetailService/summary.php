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
<!--                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Jumlah per Halaman</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php //echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
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
                                        <?php //echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    
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
                                        <?php echo CHtml::activeTextField($service, 'name', array(
                                            'onchange' => '
                                            $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                                service_category_id: $("#Service_service_category_id").val(),
                                                service_type_id: $("#Service_service_type_id").val(),
                                                code: $("#Service_code").val(),
                                                name: $(this).val(),
                                            } } });',
                                        )); ?>
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
                    
<!--                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Kategori</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php /*echo CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                            'onchange' => '
                                            $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                                service_category_id: $(this).val(),
                                                service_type_id: $("#Service_service_type_id").val(),
                                                code: $("#Service_code").val(),
                                                name: $("#Service_name").val(),
                                            } } });',
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                            'onchange' => '
                                            $.fn.yiiGridView.update("service-grid", {data: {Service: {
                                                service_category_id: $("#Service_service_category_id").val(),
                                                service_type_id: $(this).val(),
                                                code: $("#Service_code").val(),
                                                name: $("#Service_name").val(),
                                            } } });',
                                        ));*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    
                    <div class="row">                        
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
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'saleRetailServiceReport' => $saleRetailServiceReport,
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