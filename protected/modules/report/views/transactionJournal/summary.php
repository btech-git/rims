<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div class="tab reportTab">
    <div class="tabHead">
        <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
    </div>

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
                                        'onchange' => 'jQuery.ajax({
                                            type: "POST",
                                            url: "' . CController::createUrl('ajaxGetBranch') . '",
                                            data: jQuery("form").serialize(),
                                            success: function(data){
                                                console.log(data);
                                                jQuery("#branch").html(data);

                                            },
                                        });'
                                    )); ?>
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
                                    <span class="prefix">Branch </span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php if ($companyId == ""): ?>
                                        <?php echo CHtml::activeDropDownlist($jurnalUmum, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                    <?php else: ?>
                                        <?php echo CHtml::activeDropDownlist($jurnalUmum, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active', 'company_id' => $company)), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                    <?php endif; ?>
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
                                    <span class="prefix">Transaction Type</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownlist($jurnalUmum, 'transaction_type', array(
                                        'PO' => 'PURCHASE',
                                        'RG' => 'BR / GR',
                                        'DO' => 'DELIVERY',
                                        'TR' => 'TRANSFER REQUEST',
                                        'RCI' => 'RECEIVE',
                                        'CSI' => 'CONSIGNMENT IN',
                                        'CSO' => 'CONSIGNMENT OUT',
                                        'MI' => 'MOVEMENT IN',
                                        'MO' => 'MOVEMENT OUT',
                                        'Pin' => 'PAYMENT IN',
                                        'Pout' => 'PAYMENT OUT',
                                        'SO' => 'SALES',
                                        'CASH' => 'CASH TRANSACTION',
                                    ), array('empty' => '-- All Transaction --')); ?>
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
                                    <span class="prefix">COA </span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($jurnalUmum, 'coa_id', array('onclick' => 'jQuery("#coa-dialog").dialog("open"); return false;')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
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
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php //echo ReportHelper::summaryText($saleSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summary', array(
                    'jurnalUmum' => $jurnalUmum,
                    'jurnalUmumSummary' => $jurnalUmumSummary,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'companyId' => $companyId,
//                    'branchId' => $branchId,
//                    'transactionType' => $transactionType,
//                    'coaId' => $coaId,
                    'coa' => $coa,
                    'coaDataProvider' => $coaDataProvider,
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
                        $("#coa_id").val(data.id);
                        $("#coa_name").val(data.code);
                    },
                });
                $("#coa-grid").find("tr.selected").each(function(){
                   $(this).removeClass( "selected" );
                });
            }',
            'columns'=> array(
                'code',
                'name',
                array(
                    'name' => 'coa_category_id',
                    'filter' => CHtml::activeDropDownList($coa, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->coaCategory!="" ? $data->coaCategory->name : ""',
                ),
                array(
                    'name' => 'coa_sub_category_id',
                    'filter' => CHtml::activeDropDownList($coa, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                    'value' => '$data->coaSubCategory!="" ? $data->coaSubCategory->name : ""'
                ),
            ),
        )); ?>
    
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>