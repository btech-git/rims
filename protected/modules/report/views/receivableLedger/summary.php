<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $receivableLedgerSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($receivableLedgerSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">COA </span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('CoaId', $coaId, CHtml::listData(Coa::model()->findAllbyAttributes(array('is_approved' => 1, 'coa_sub_category_id' => 8), array('order' => 't.code ASC')), 'id', 'codeName'), array('empty' => '-- All COA --')); ?>
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
                                        <span class="prefix">Periode:</span>
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
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php /*$this->renderPartial('_summary', array(
                        'receivableLedgerSummary' => $receivableLedgerSummary,
                        'account' => $account,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    ));*/ ?>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>