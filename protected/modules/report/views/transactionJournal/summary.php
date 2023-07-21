<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
            
	$("#PageSize").val("' . $jurnalUmumSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($jurnalUmumSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                    <span class="prefix">Company </span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownlist('CompanyId', $companyId, CHtml::listData(Company::model()->findAllByAttributes(array('is_deleted' => 0)), 'id', 'name'), array('empty' => '-- All Company --',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateBranchSelect'),
                                            'update' => '#branch',
                                        ))
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction Type</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownlist($jurnalUmum, 'transaction_type', array(
                                        'Invoice' => 'Sales',
                                        'CASH' => 'Cash',
                                        'Pout' => 'Purchase Payment',
                                        'Pin' => 'Sales Receipt',
                                        'MI' => 'Movement In',
                                        'MO' => 'Movement Out',
                                        'MR' => 'Material',
//                                        'Invoice GR' => 'GENERAL REPAIR',
//                                        'Invoice BR' => 'BODY REPAIR',
//                                        'DO' => 'DELIVERY',
//                                        'TR' => 'TRANSFER REQUEST',
//                                        'RCI' => 'RECEIVE',
//                                        'CSI' => 'CONSIGNMENT IN',
//                                        'CSO' => 'CONSIGNMENT OUT',
//                                        'JP' => 'JURNAL UMUM',
                                    ), array('empty' => '-- All Transaction --')); ?>
                                </div>
                            </div>
                        </div>
                        
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
                    
                    <div class="medium-6 columns">
<!--                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Jumlah per Halaman </span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::hiddenField('PageSize', $pageSize, array('size' => 3)); ?>
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Halaman saat ini</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?>
                                </div>
                            </div>
                        </div>

                        <div id="branch">
                            <?php $this->renderPartial('_branchSelect', array(
                                'companyId' => $companyId,
                                'branchId' => $branchId,
                            )); ?>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">COA </span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($jurnalUmum, 'coa_id', array(
                                        'readonly' => true,
                                        'onclick' => 'jQuery("#coa-dialog").dialog("open"); return false;',
                                        'onkeypress' => 'if (event.keyCode == 13) { $("#coa-dialog").dialog("open"); return false; }'
                                    )); ?>
                                    <?php echo CHtml::openTag('span', array('id' => 'coa_name')); ?>
                                    <?php $coa = Coa::model()->findByPk($jurnalUmum->coa_id); ?>
                                    <?php echo CHtml::encode(CHtml::value($coa, 'combinationName')); ?>
                                    <?php echo CHtml::closeTag('span'); ?> 
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

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($jurnalUmumSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summary', array(
                    'jurnalUmum' => $jurnalUmum,
                    'jurnalUmumSummary' => $jurnalUmumSummary,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'companyId' => $companyId,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="grid-view">
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA ',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'coa-grid',
        'dataProvider'=>$accountDataProvider,
        'filter'=>$account,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'selectionChanged'=>'js:function(id){
            $("#' . CHtml::activeId($jurnalUmum, 'coa_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#coa-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#coa_id").html("");
                $("#coa_name").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonCoa') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#coa_id").html(data.coa_code);
                        $("#coa_name").html(data.coa_name);
                    },
                });
            }
        }',
        'columns'=> array(
            'code',
            'name',
            array(
                'name' => 'coa_category_id',
                'filter' => CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->coaCategory!="" ? $data->coaCategory->name : ""',
            ),
            array(
                'name' => 'coa_sub_category_id',
                'filter' => CHtml::activeDropDownList($account, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->coaSubCategory!="" ? $data->coaSubCategory->name : ""'
            ),
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>