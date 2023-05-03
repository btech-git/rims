<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#PageSize").val("' . $payableSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($payableSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
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
                                        <span class="prefix">Jumlah per Halaman</span>
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
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
<!--                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                                        ));*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Supplier </span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('SupplierId', $supplierId, array(
                                            'readonly' => true,
                                            'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                                        )); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                                        <?php $supplierModel = Supplier::model()->findByPk($supplierId); ?>
                                        <?php echo CHtml::encode(CHtml::value($supplierModel, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="right"><?php echo ReportHelper::summaryText($payableSummary->dataProvider); ?></div>
                <br />
                <div class="right"><?php echo ReportHelper::sortText($payableSummary->dataProvider->sort, array('Tanggal', 'Supplier')); ?></div>
                <div class="clear"></div>

                <br />
        
                <div class="relative">
                    <div class="reportDisplay">
                        <?php echo ReportHelper::summaryText($payableSummary->dataProvider); ?>
                        <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                    </div>

                    <?php $this->renderPartial('_summary', array(
                        'payableSummary' => $payableSummary,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
            
            <br/>

            <div class="hide">
                <div class="right"></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'supplier-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Supplier',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'supplier-grid',
        'dataProvider' => $supplierDataProvider,
        'filter' => $supplier,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#SupplierId").val($.fn.yiiGridView.getSelection(id));
            $("#supplier-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "")
            {
                $("#supplier_name").html("");
                $("#supplier_code").html("");
            }
            else
            {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonSupplier') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#supplier_name").html(data.supplier_name);
                        $("#supplier_code").html(data.supplier_code);
                    },
                });
            }
        }',
        'columns' => array(
            'code',
            'name',
            'company',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
