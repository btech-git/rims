<?php
/* @var $this ProductMasterCategoryController */
/* @var $model ProductMasterCategory */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/productMasterCategory/admin'; ?>"><span class="fa fa-th-list"></span>Manage Product Master Category</a>
    <h1><?php if ($model->isNewRecord) {
    echo "New Product Master Category";
} else {
    echo "Update Product Master Category";
} ?></h1>
    <hr />
    <!-- begin FORM -->
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-master-category-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="medium-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'code'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'code', array('size' => 20, 'maxlength' => 20)); ?>
                            <?php echo $form->error($model, 'code'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'name'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'description'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
                            <?php echo $form->error($model, 'name'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'status'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($model, 'status', array(
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                            ), array('prompt' => 'Select',)); ?>
                            <?php echo $form->error($model, 'status'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <h3>Assign Warehouses</h3>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <table>
                            <?php foreach ($branches as $branch): ?>
                                <tr>
                                    <td><?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></td>
                                    <td><?php echo CHtml::dropDownList("WarehouseId[{$branch->id}]", $warehouseIds[$branch->id], CHtml::listData(Warehouse::model()->findAllByAttributes(array('branch_id' => $branch->id)), 'id', 'name'), array('empty' => '-- Pilih --')); ?></td>
                                    <td><?php echo CHtml::errorSummary($warehouseBranchProductCategories[$branch->id]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
                </div>
            </div>
            <div class="medium-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_persediaan_barang_dagang'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_persediaan_barang_dagang'); ?>
                            <?php echo $form->textField($model, 'coa_persediaan_barang_dagang_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-persediaan-dialog").dialog("open"); return false;', 'value' => $model->coa_persediaan_barang_dagang != "" ? Coa::model()->findByPk($model->coa_persediaan_barang_dagang)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_persediaan_barang_dagang_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_persediaan_barang_dagang != "" ? Coa::model()->findByPk($model->coa_persediaan_barang_dagang)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_persediaan_barang_dagang'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_hpp'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_hpp'); ?>
                            <?php echo $form->textField($model, 'coa_hpp_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-hpp-dialog").dialog("open"); return false;', 'value' => $model->coa_hpp != "" ? Coa::model()->findByPk($model->coa_hpp)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_hpp_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_hpp != "" ? Coa::model()->findByPk($model->coa_hpp)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_hpp'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_penjualan_barang_dagang'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_penjualan_barang_dagang'); ?>
                            <?php echo $form->textField($model, 'coa_penjualan_barang_dagang_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-penjualan-dialog").dialog("open"); return false;', 'value' => $model->coa_penjualan_barang_dagang != "" ? Coa::model()->findByPk($model->coa_penjualan_barang_dagang)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_penjualan_barang_dagang_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_penjualan_barang_dagang != "" ? Coa::model()->findByPk($model->coa_penjualan_barang_dagang)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_penjualan_barang_dagang'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_retur_penjualan'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_retur_penjualan'); ?>
                            <?php echo $form->textField($model, 'coa_retur_penjualan_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-retur-dialog").dialog("open"); return false;', 'value' => $model->coa_retur_penjualan != "" ? Coa::model()->findByPk($model->coa_retur_penjualan)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_retur_penjualan_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_retur_penjualan != "" ? Coa::model()->findByPk($model->coa_retur_penjualan)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_retur_penjualan'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_diskon_penjualan'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_diskon_penjualan'); ?>
                            <?php echo $form->textField($model, 'coa_diskon_penjualan_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-diskon-dialog").dialog("open"); return false;', 'value' => $model->coa_diskon_penjualan != "" ? Coa::model()->findByPk($model->coa_diskon_penjualan)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_diskon_penjualan_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_diskon_penjualan != "" ? Coa::model()->findByPk($model->coa_diskon_penjualan)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_diskon_penjualan'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_retur_pembelian'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_retur_pembelian'); ?>
                            <?php echo $form->textField($model, 'coa_retur_pembelian_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-retur-pembelian-dialog").dialog("open"); return false;', 'value' => $model->coa_retur_pembelian != "" ? Coa::model()->findByPk($model->coa_retur_pembelian)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_retur_pembelian_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_retur_pembelian != "" ? Coa::model()->findByPk($model->coa_retur_pembelian)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_retur_pembelian'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_diskon_pembelian'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_diskon_pembelian'); ?>
                            <?php echo $form->textField($model, 'coa_diskon_pembelian_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-diskon-pembelian-dialog").dialog("open"); return false;', 'value' => $model->coa_diskon_pembelian != "" ? Coa::model()->findByPk($model->coa_diskon_pembelian)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_diskon_pembelian_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_diskon_pembelian != "" ? Coa::model()->findByPk($model->coa_diskon_pembelian)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_diskon_pembelian'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_inventory_in_transit'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_inventory_in_transit'); ?>
                            <?php echo $form->textField($model, 'coa_inventory_in_transit_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-inventory-dialog").dialog("open"); return false;', 'value' => $model->coa_inventory_in_transit != "" ? Coa::model()->findByPk($model->coa_inventory_in_transit)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_inventory_in_transit_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_inventory_in_transit != "" ? Coa::model()->findByPk($model->coa_inventory_in_transit)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_inventory_in_transit'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'coa_consignment_inventory'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'coa_consignment_inventory'); ?>
                            <?php echo $form->textField($model, 'coa_consignment_inventory_name', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'onclick' => 'jQuery("#coa-consignment-dialog").dialog("open"); return false;', 'value' => $model->coa_consignment_inventory != "" ? Coa::model()->findByPk($model->coa_consignment_inventory)->name : '')); ?>
                            <?php echo $form->textField($model, 'coa_consignment_inventory_code', array('size' => 20, 'maxlength' => 20, 'readonly' => true, 'value' => $model->coa_consignment_inventory != "" ? Coa::model()->findByPk($model->coa_consignment_inventory)->code : '')); ?>
                            <?php echo $form->error($model, 'coa_consignment_inventory'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
    <!--COA Persediaan Barang Dagang-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-persediaan-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Persediaan',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-persediaan-grid',
        'dataProvider' => $coaPersediaanDataProvider,
        'filter' => $coaPersediaan,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
            $("#coa-persediaan-dialog").dialog("close");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {
                    $("#ProductMasterCategory_coa_persediaan_barang_dagang").val(data.id);
                    $("#ProductMasterCategory_coa_persediaan_barang_dagang_code").val(data.code);
                    $("#ProductMasterCategory_coa_persediaan_barang_dagang_name").val(data.name);

                },
            });
            $("#coa-persediaan-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA HPP-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-hpp-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA HPP',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-hpp-grid',
        'dataProvider' => $coaHppDataProvider,
        'filter' => $coaHpp,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
            $("#coa-hpp-dialog").dialog("close");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {
                    $("#ProductMasterCategory_coa_hpp").val(data.id);
                    $("#ProductMasterCategory_coa_hpp_code").val(data.code);
                    $("#ProductMasterCategory_coa_hpp_name").val(data.name);
                },
            });
            $("#coa-hpp-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Retur Penjualan-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-retur-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Retur Penjualan',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    ));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-retur-grid',
        'dataProvider' => $coaReturDataProvider,
        'filter' => $coaRetur,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-retur-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_retur_penjualan").val(data.id);
					$("#ProductMasterCategory_coa_retur_penjualan_code").val(data.code);
					$("#ProductMasterCategory_coa_retur_penjualan_name").val(data.name);
					
				},
			});
			$("#coa-retur-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Diskon Penjualan-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-diskon-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Diskon Penjualan',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-diskon-grid',
        'dataProvider' => $coaDiskonDataProvider,
        'filter' => $coaDiskon,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-diskon-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_diskon_penjualan").val(data.id);
					$("#ProductMasterCategory_coa_diskon_penjualan_code").val(data.code);
					$("#ProductMasterCategory_coa_diskon_penjualan_name").val(data.name);
					
				},
			});
			$("#coa-diskon-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Penjualan-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-penjualan-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Penjualan',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-penjualan-grid',
        'dataProvider' => $coaPenjualanDataProvider,
        'filter' => $coaPenjualan,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-penjualan-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_penjualan_barang_dagang").val(data.id);
					$("#ProductMasterCategory_coa_penjualan_barang_dagang_code").val(data.code);
					$("#ProductMasterCategory_coa_penjualan_barang_dagang_name").val(data.name);
					
				},
			});
			$("#coa-penjualan-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Retur Pembelian-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-retur-pembelian-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Retur Pembelian',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-retur-pembelian-grid',
        'dataProvider' => $coaReturPembelianDataProvider,
        'filter' => $coaReturPembelian,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-retur-pembelian-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_retur_pembelian").val(data.id);
					$("#ProductMasterCategory_coa_retur_pembelian_code").val(data.code);
					$("#ProductMasterCategory_coa_retur_pembelian_name").val(data.name);
					
				},
			});
			$("#coa-retur-pembelian-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Diskon Pembelian-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-diskon-pembelian-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Diskon Pembelian',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-diskon-pembelian-grid',
        'dataProvider' => $coaDiskonPembelianDataProvider,
        'filter' => $coaDiskonPembelian,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-diskon-pembelian-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_diskon_pembelian").val(data.id);
					$("#ProductMasterCategory_coa_diskon_pembelian_code").val(data.code);
					$("#ProductMasterCategory_coa_diskon_pembelian_name").val(data.name);
					
				},
			});
			$("#coa-diskon-pembelian-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

    <!--COA Inventory In Transit-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-inventory-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Inventory',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-inventory-grid',
        'dataProvider' => $coaInventoryDataProvider,
        'filter' => $coaInventory,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-inventory-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_inventory_in_transit").val(data.id);
					$("#ProductMasterCategory_coa_inventory_in_transit_code").val(data.code);
					$("#ProductMasterCategory_coa_inventory_in_transit_name").val(data.name);
					
				},
			});
			$("#coa-inventory-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


    <!--COA Consignment Inventory-->
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-consignment-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA Consignment',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'coa-consignment-grid',
        'dataProvider' => $coaConsignmentDataProvider,
        'filter' => $coaConsignment,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id){
			$("#coa-consignment-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#ProductMasterCategory_coa_consignment_inventory").val(data.id);
					$("#ProductMasterCategory_coa_consignment_inventory_code").val(data.code);
					$("#ProductMasterCategory_coa_consignment_inventory_name").val(data.name);
					
				},
			});
			$("#coa-consignment-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
        'columns' =>
        //$coumns
        array(
            'name',
            'code',
        ),
    ));
    ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>