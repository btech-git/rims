<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
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
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::hiddenField('PageSize', $pageSize); ?>
                                        <?php echo CHtml::textField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
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
                            <div class="field">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Code</td>
                                            <td>Name</td>
                                            <td>Category</td>
                                            <td>Sub Category</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><?php echo CHtml::activeTextField($account, 'code'); ?></td>

                                            <td><?php echo CHtml::activeTextField($account, 'name'); ?></td>

                                            <td>
                                                <?php echo CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                                    'empty' => '-- All --',
                                                )); ?>
                                            </td>

                                            <td>
                                                <div id="sub_category">
                                                    <?php echo CHtml::activeDropDownList($account, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                                        'empty' => '-- All --',
                                                    )); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
            
<!--                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">COA </span>
                                    </div>

                                    <div class="small-8 columns">-->
                                        <?php /*echo CHtml::activeTextField($account, 'id', array(
                                            'readonly' => true,
                                            'onclick' => 'jQuery("#coa-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#coa-dialog").dialog("open"); return false; }'
                                        )); ?>
                                        <?php echo CHtml::openTag('span', array('id' => 'coa_name')); ?>
                                        <?php $coaAccount = Coa::model()->findByPk($account->id); ?>
                                        <?php echo CHtml::encode(CHtml::value($coaAccount, 'combinationName')); ?>
                                        <?php echo CHtml::closeTag('span');*/ ?> 
<!--                                    </div>
                                </div>-->
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
                    <div class="reportDisplay">
                        <?php echo ReportHelper::summaryText($generalLedgerSummary->dataProvider); ?>
                        <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                    </div>

                    <?php $this->renderPartial('_summary', array(
                        'account' => $account,
                        'generalLedgerSummary' => $generalLedgerSummary,
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
            $("#' . CHtml::activeId($account, 'id') . '").val($.fn.yiiGridView.getSelection(id));
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