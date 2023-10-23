<?php echo CHtml::beginForm(array(''), 'get'); ?>

<div class="row">
    <div class="medium-6 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Branch </span>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="medium-6 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Transaction Type</span>
                </div>

                <div class="small-8 columns">
                    <?php echo CHtml::dropDownlist('TransactionType', $transactionType, array(
                        'Invoice' => 'Sales',
                        'CASH' => 'Cash',
                        'JP' => 'Penyesuaian',
                        'Pout' => 'Purchase Payment',
                        'Pin' => 'Sales Receipt',
                        'MI' => 'Movement In',
                        'MO' => 'Movement Out',
                        'MR' => 'Material',
                        'PO' => 'PURCHASE',
//                                            'DO' => 'DELIVERY',
//                                            'TR' => 'TRANSFER REQUEST',
//                                            'RCI' => 'RECEIVE',
//                                            'Pin' => 'PAYMENT IN',
//                                            'Pout' => 'PAYMENT OUT',
//                                            'SO' => 'SALES',
                    ), array('empty' => '-- All Transaction --')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="medium-12 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Periode:</span>
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

<!--                    <div class="row">
    <div class="medium-12 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix">COA Category:</span>
                </div>
                <div class="small-10 columns">
                    <?php /*echo CHtml::checkBoxList('CoaCategoryList', $coaCategoryList, CHtml::listData(CoaCategory::model()->findAll(array(
                        'condition' => 'id NOT IN (11, 12, 13, 22, 1, 2, 3)', 
                        'order' => 'code ASC'
                    )), 'id', 'name'), array('separator'=>'', 'labelOptions'=>array('style'=>'display:inline')));*/ ?>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="row">
    <div class="medium-12 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix">COA Sub Category:</span>
                </div>
                <div class="small-10 columns">
                    <?php echo CHtml::checkBoxList('CoaSubCategoryList', $coaSubCategoryList, CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'code ASC')), 'id', 'name'), array('separator'=>'', 'labelOptions'=>array('style'=>'display:inline'))); ?>
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