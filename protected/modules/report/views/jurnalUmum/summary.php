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
				<div class="myForm tabForm customer">

					<?php echo CHtml::beginForm(array(''), 'get'); ?>

					<div class="span-12">
                        <div class="row">
                            <label>Tanggal Mulai</label>
                            <div class="field">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name'=>'tanggal_mulai',
                                    'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                    ),
                                ));
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row">
                            <label>Sampai</label>
                            <div class="field">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name'=>'tanggal_sampai',
                                    'options'=>array(
                                        'dateFormat'=>'yy-mm-dd',
                                    ),
                                    'htmlOptions'=>array(
                                        'readonly'=>true,
                                    ),
                                ));
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div>
						
					</div>
					
					
                    <div class="clear"></div>
                    <?php //echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort')); ?>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
                        <?php //echo CHtml::resetButton('Hapus'); ?>
						<?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
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
					<?php $this->renderPartial('_summary', array('transaksiPembelianSummary'=>$transaksiPembelianSummary,'tanggal_mulai'=>$tanggal_mulai,'tanggal_sampai'=>$tanggal_sampai)); ?>
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