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
                                        <span class="prefix">Branch</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                    </div>
                                </div>
<!--                                <table>
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
                                            <td><?php /*echo CHtml::activeTextField($account, 'code'); ?></td>
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
                                                    ));*/ ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>-->
<!--                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">COA </span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php //echo CHtml::dropDownList('CoaId', $coaId, CHtml::listData(Coa::model()->findAllbyAttributes(array('is_approved' => 1, 'coa_sub_category_id' => 8), array('order' => 't.code ASC')), 'id', 'codeName'), array('empty' => '-- All COA --')); ?>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        
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
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
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
                        'receivableLedgerSummary' => $receivableLedgerSummary,
                        'account' => $account,
                        'branchId' => $branchId,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>