<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/accounting/journalAdjustment/admin';?>"><span class="fa fa-th-list"></span>Manage</a>
        <h1><?php if ($journalVoucher->header->isNewRecord){ echo "New Jurnal Umum"; }else{ echo "Update Jurnal Umum";}?></h1>

        <div class="form">
            <?php echo CHtml::beginForm(); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
            <span style="color: red; font-weight: bold"><?php echo CHtml::errorSummary($journalVoucher->header); ?></span>
            <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <?php if (!$journalVoucher->header->isNewRecord): ?>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo CHtml::label('Jurnal #', false); ?></label>
                                        </div>

                                        <div class="small-8 columns">
                                            <?php echo CHtml::encode($journalVoucher->header->transaction_number); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('Tanggal', ''); ?></label>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $journalVoucher->header,
                                            'attribute' => 'date',
                                            // additional javascript options for the date picker plugin
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($journalVoucher->header, 'date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('User', false); ?></label>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($journalVoucher->header, 'user.username')); ?>
                                        <?php echo CHtml::error($journalVoucher->header, 'user_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('Status', false); ?></label>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($journalVoucher->header, 'status')); ?>
                                        <?php echo CHtml::error($journalVoucher->header, 'status'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('Branch', false); ?></label>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($journalVoucher->header, 'branch.name')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('Catatan', false); ?></label>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($journalVoucher->header, 'note', array('rows' => 5)); ?>
                                        <?php echo CHtml::error($journalVoucher->header, 'note'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                <?php /*echo CHtml::button('Tambah Akun', array(
                    'onclick' => '$("#account-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::hiddenField('CoaId');*/ ?>
            </div>

            <div class="row">
                <?php echo CHtml::button('Tambah Akun', array('name' => 'Search', 'onclick' => '$("#account-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }')); ?>
                <?php //echo CHtml::hiddenField('CoaId'); ?>
            </div>

            <br />

            <div id="detail_div">
                <?php $this->renderPartial('_detail', array('journalVoucher' => $journalVoucher)); ?>
            </div>

            <br />

            <div class="row buttons">
                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
            <?php echo IdempotentManager::generate(); ?>

            <?php echo CHtml::endForm(); ?>

        </div>
    </div>
</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'account-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
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
                        <td>
                            <?php echo CHtml::activeTextField($account, 'code', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("account-grid", {data: {Coa: {
                                    code: $(this).val(),
                                    name: $("#coa_name").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::activeTextField($account, 'name', array(
                                'onchange' => '
                                $.fn.yiiGridView.update("account-grid", {data: {Coa: {
                                    name: $(this).val(),
                                    code: $("#coa_code").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateSubCategorySelect'),
                                    'update' => '#sub_category',
                                )) . '$.fn.yiiGridView.update("account-grid", {data: {Coa: {
                                    coa_category_id: $(this).val(),
                                    id: $("#coa_id").val(),
                                    code: $("#coa_code").val(),
                                    name: $("#coa_name").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <div id="sub_category">
                                <?php echo CHtml::activeDropDownList($account, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                    $.fn.yiiGridView.update("account-grid", {data: {Coa: {
                                        coa_sub_category_id: $(this).val(),
                                        code: $("#coa_code").val(),
                                        coa_category_id: $("#coa_category_id").val(),
                                        name: $("#coa_name").val(),
                                    } } });',
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
    
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'account-grid',
                'dataProvider' => $dataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'id' => 'selectedIds',
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '50',
                    ),
                    'code: Kode',
                    array(
                        'header' => 'Nama Akun',
                        'value' => 'CHtml::encode(CHtml::value($data, "name"))'
                    ),
                    array(
                        'header' => 'Category',
                        'value' => 'CHtml::encode(CHtml::value($data, "coaCategory.name"))'
                    ),
                    array(
                        'header' => 'Sub Category',
                        'value' => 'CHtml::encode(CHtml::value($data, "coaSubCategory.name"))'
                    ),
                ),
            )); ?>

            <?php echo CHtml::ajaxSubmitButton('Add COA', CController::createUrl('AjaxHtmlAddDetail', array('id' => $journalVoucher->header->id)), array(
                'type' => 'POST',
                'data' => 'js:$("form").serialize()',
                'success' => 'js:function(html) {
                    $("#detail_div").html(html);
                    $("#account-dialog").dialog("close");
                }'
            )); ?>
        </div>
    </div>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('myjavascript', '
        $(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>