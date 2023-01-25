<?php
$this->breadcrumbs = array(
    'Report',
    'Pembelian',
        // 'Outstanding ',
);
?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 medium-12 columns">
            <h1 class="report-title">Laporan Pembelian</h1>
        </div>
        <div class="small-12 medium-12 columns">

            <?php
            Yii::app()->clientScript->registerScript('report', '
	 $("#tanggal_mulai").val("' . $tanggal_mulai . '");
     $("#tanggal_sampai").val("' . $tanggal_sampai . '");
     $("#branch").val("' . $branch . '");
     $("#company").val("' . $company . '");
     $("#supplier_id").val("' . $supplier_id . '");
	 $("#payment_type").val("' . $paymentType . '");
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
            ?>
            <div class="tab reportTab">
                <div class="tabHead">
                    <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
                </div>
                <div class="tabBody">
                    <div id="detail_div">
                        <div>
                            <div class="myForm" id="myForm">

                                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                                <div class="row">
                                    <div class="medium-6 columns">
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <span class="prefix">Company </span>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php
                                                    echo CHtml::dropDownlist('company', $company, CHtml::listData(Company::model()->findAll(), 'id', 'name'), array('empty' => '-- All Company --',
                                                        'onchange' => '
                                                console.log($(this).val());
                                                       
                                                             jQuery.ajax({
                                                                type: "POST",
                                                                url: "' . CController::createUrl('ajaxGetBranch') . '",
                                                                data: jQuery("form").serialize(),
                                                                success: function(data){
                                                                    console.log(data);
                                                                    jQuery("#branch").html(data);
                                                                    
                                                                },
                                                            });
                                                       
                                               '
                                                    ));
                                                    ?>
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
                                                    <?php if ($company == ""): ?>
                                                        <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                                    <?php else: ?>
    <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active', 'company_id' => $company)), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
<?php endif ?>

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
                                                    <span class="prefix">Payment Type </span>
                                                </div>
                                                <div class="small-8 columns">
<?php echo CHtml::dropDownlist('payment_type', $paymentType, array('Cash' => 'Cash', 'Credit' => 'Credit'), array('empty' => '-- All Payment Type --')); ?>
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
                                                    <span class="prefix">Supplier </span>
                                                </div>
                                                <div class="small-8 columns">
<?php echo CHtml::hiddenField('supplier_id', $supplier_id); ?>
<?php echo CHtml::textField('supplier_name', $supplier_id != "" ? Supplier::model()->findByPK($supplier_id)->name : '', array('readonly' => 'true', 'onclick' => 'jQuery("#supplier-dialog").dialog("open"); return false;')); ?>
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
                                                    <?php
                                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                        'name' => 'tanggal_mulai',
                                                        'options' => array(
                                                            'dateFormat' => 'yy-mm-dd',
                                                        ),
                                                        'htmlOptions' => array(
                                                            'readonly' => true,
                                                            'placeholder' => 'Mulai',
                                                        ),
                                                    ));
                                                    ?>
                                                </div>

                                                <div class="small-5 columns">
                                                    <?php
                                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                        'name' => 'tanggal_sampai',
                                                        'options' => array(
                                                            'dateFormat' => 'yy-mm-dd',
                                                        ),
                                                        'htmlOptions' => array(
                                                            'readonly' => true,
                                                            'placeholder' => 'Sampai',
                                                        ),
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div><?php //echo $getCoa == "" ? '-' : $getCoa;  ?></div>
                                <div><?php //print_r($allCoa);  ?></div>

                                <div class="clear"></div>
                                    <?php //echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort')); ?>
                                <div class="row buttons">
<?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                                    <?php echo CHtml::submitButton('Hapus', array('onclick' => 'resetForm($("#myform"));')); ?>

                                    <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
<?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                                </div>


<?php echo CHtml::endForm(); ?>
                                <div class="clear"></div>

                            </div>

                            <hr />

                            <div class="relative">
                                <div class="reportDisplay">
                                <?php //echo ReportHelper::summaryText($saleSummary->dataProvider);  ?>
                                <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                                </div>
<?php $this->renderPartial('_laporanPembelian', array('transactions' => $transactions, 'tanggal_mulai' => $tanggal_mulai, 'tanggal_sampai' => $tanggal_sampai, 'branch' => $branch)); ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <br/>

                        <div class="hide">
                            <div class="right">


                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'supplier-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Supplier ',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'supplier-grid',
    'dataProvider' => $supplierDataProvider,
    'filter' => $supplier,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
            $("#supplier-dialog").dialog("close");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                data: $("form").serialize(),
                success: function(data) {
                    $("#supplier_id").val(data.id);
                    $("#supplier_name").val(data.name);
                },
            });
            $("#supplier-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
        }',
    'columns' =>
    array(
        'name',
        'code',
    ),
));
?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
    function resetForm($form) {
        $("#supplier_id").val('');
        $("#supplier_name").val('');
        $("#tanggal_mulai").val('');
        $("#tanggal_sampai").val('');
        $("#branch").val('');
        $("#company").val('');
        $("#payment_type").val('');
        // $form.find('input:text').val('');
        $form.find('input:radio, input:checkbox')
                .removeAttr('checked').removeAttr('selected');
    }
</script>