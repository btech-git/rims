<?php
Yii::app()->clientScript->registerScript('report', '
	$("#tanggal_mulai").val("' . $tanggal_mulai . '");
    $("#tanggal_sampai").val("' . $tanggal_sampai . '");
    $("#branch").val("' . $branch . '");
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
                <h1>Kertas Kerja</h1>
					<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Company </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('company', $company, CHtml::listData(Company::model()->findAllByAttributes(array('is_deleted' => 0)), 'id','name'), array('empty'=>'-- All Company --',
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
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                         <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name'=>'tanggal_mulai',
                                                'options'=>array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>true,
                                                    'placeholder'=>'Mulai',
                                                ),
                                            ));
                                            ?>
                                    </div>
                                   
                                    <div class="small-5 columns">
                                         <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name'=>'tanggal_sampai',
                                                'options'=>array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>true,
                                                    'placeholder'=>'Sampai',
                                                ),
                                            ));
                                            ?>
                                    </div>
                                 </div>
                            </div>
                           
                        </div>
                    </div>
					
					
					
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
					<?php $this->renderPartial('_kertasKerja', array('showCoas'=>$showCoas,'branch'=>$branch,'tanggal_mulai'=>$tanggal_mulai,'tanggal_sampai'=>$tanggal_sampai,'company'=>$company)); ?>
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
