<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#VehicleId").val("' . $vehicleId . '");
	$("#PageSize").val("' . $saleInvoiceSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($saleInvoiceSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Jumlah per Halaman</label>
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
                                    <label class="prefix">Halaman saat ini</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Customer</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($invoiceHeader, 'customer_id', array(
                                        'readonly' => true,
                                        'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                                        'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                                    )); ?>

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
                                            $("#' . CHtml::activeId($invoiceHeader, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                                            $("#customer-dialog").dialog("close");
                                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                                $("#customer_name").html("");
                                            } else {
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $invoiceHeader->id)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#customer_name").html(data.customer_name);
                                                    },
                                                });
                                                $.ajax({
                                                    type: "GET",
                                                    url: "' . CController::createUrl('ajaxHtmlUpdateVehicleList') . '",
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $("#vehicle_list_span").html(html);
                                                    },
                                                });
                                            }
                                        }',
                                        'columns' => array(
                                            'name',
                                            'customer_type',
                                            'mobile_phone',
                                        ),
                                    )); ?>
                                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                    <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'customer.name')); ?>
                                    <?php echo CHtml::closeTag('span'); ?>    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Type</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownlist('CustomerType', $customerType, array(
                                        'INDIVIDUAL' => 'INDIVIDUAL', 
                                        'COMPANY' => 'COMPANY'
                                    ), array('empty' => '-- All Type --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Vehicle Plate #</label>
                                </div>
                                <div class="small-8 columns">
                                    <span id="vehicle_list_span">
                                        <?php $this->renderPartial('_vehicleList', array(
                                            'vehicles' => $vehicles,
                                            'vehicleId' => $vehicleId,
                                        )); ?>
                                    </span>
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
                                      <?php echo CHtml::activeDropDownlist($invoiceHeader, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="medium-6 columns">
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

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">PPn/non</span>
                                </div>
                                 <div class="small-8 columns">
                                      <?php echo CHtml::activeDropDownlist($invoiceHeader, 'ppn', array(
                                          '0' => 'Non PPn',
                                          '1' => 'PPn',
                                      ), array('empty'=>'-- All --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <div class="row">
                    <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($saleInvoiceSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summary', array(
                    'saleInvoiceSummary' => $saleInvoiceSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <div class="right">
                <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
                    'itemCount' => $saleInvoiceSummary->dataProvider->pagination->itemCount,
                    'pageSize' => $saleInvoiceSummary->dataProvider->pagination->pageSize,
                    'currentPage' => $saleInvoiceSummary->dataProvider->pagination->getCurrentPage(false),
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>