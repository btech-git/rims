<?php
Yii::app()->clientScript->registerScript('report', '
	 $("#tanggal_mulai").val("' . $tanggal_mulai . '");
	 $("#tanggal_sampai").val("' . $tanggal_sampai . '");
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
				<div class="myForm">
                    <h1>Buku Besar</h1>
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                     <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Company </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('company', $company, CHtml::listData(Company::model()->findAllByAttributes(array('is_deleted' => 0)), 'id','name'), array(
                                            'empty'=>'-- All Company --',
                                            'onchange'=>'jQuery.ajax({
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
                                         <?php if ($company == ""): ?>
                                          <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                      <?php else: ?>
                                             <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active','company_id'=>$company)), 'id','name'), array('empty'=>'-- All Branch --')); ?>
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
                                        <span class="prefix">COA </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::hiddenField('coa_id', $coaData);?>
                                        <?php echo CHtml::textField('coa_name', $coaData != "" ? COA::model()->findByPK($coaData)->name :'',array('onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;'));?>
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
                                            'name'=>'tanggal_mulai',
                                            'options'=>array(
                                                'dateFormat'=>'yy-mm-dd',
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true,
                                                'placeholder'=>'Mulai',
                                            ),
                                        )); ?>
                                    </div>
                                   
                                    <div class="small-5 columns">
                                         <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name'=>'tanggal_sampai',
                                            'options'=>array(
                                                'dateFormat'=>'yy-mm-dd',
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>true,
                                                'placeholder'=>'Sampai',
                                            ),
                                        )); ?>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
					
					<div><?php //echo $getCoa == "" ? '-' : $getCoa; ?></div>
                    <div><?php //print_r($allCoa); ?></div>
					
                    <div class="clear"></div>
                    <?php //echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort')); ?>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
                       
                      <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
						<?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
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
					<?php $this->renderPartial('_bukubesar', array(
                        'allCoa'=>$allCoa,
                        'tanggal_mulai'=>$tanggal_mulai, 
                        'tanggal_sampai'=>$tanggal_sampai,
                        'branch'=>$branch,
                        'company'=>$company, 
                        'coaData' =>$coaData,
                        'coaSub' => $coaSub,
                        'coaSubDataProvider' => $coaSubDataProvider,
                        'coaCategory' => $coaCategory,
                        'coaCategoryDataProvider' => $coaCategoryDataProvider,
                    )); ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA ',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),));
    ?>
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
        'columns'=>
        //$coumns
        array(
            'code',
            'name',
            array(
                'name'=>'coa_category_id',
                'header' => 'Kategori',
                'filter' => CHtml::activeDropDownList($coa, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'$data->coaCategory->name'
            ),
            array(
                'name'=>'coa_sub_category_id',
                'header' => 'Sub Kategori',
                'filter' => CHtml::activeDropDownList($coa, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'$data->coaSubCategory->name'
            ),
        ),
    )); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
// $(document).ready(function() {
//     $("#reset").click(function() {
//         //$('.myform').find('input, select').not(':button, :submit, :reset,').val('');
//         //$('#coa_id').val('');
//         //alert("test");
//          $("#coa_name").val('');
//          alert
//          //$("#branch").val('');
//         //document.getElementsByClassName("myForm").reset();
//     });
// });
</script>