<?php echo CHtml::beginForm(array(''), 'get'); ?>

<div class="row">
    <div class="medium-6 columns">
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
                    <span class="prefix">Branch </span>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
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