<?php 
$this->breadcrumbs= array(
    'Report',
    'Body Repair',
    // 'Outstanding ',
    );
    ?>
    <div id="maincontent">
        <div class="row">
            <div class="small-12 medium-12 columns">
                <h1 class="report-title">Laporan Body Repair</h1>
            </div>
            <div class="small-12 medium-12 columns">
<div class="tab reportTab">
    <div class="tabHead">
        <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
    </div>
    <div class="tabBody">
		<div id="detail_div">
			<div>
				<div class="myForm">

					<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <?php /*
                                    <div class="small-4 columns">
                                        <span class="prefix">Rekap Stok </span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('type', $type, $sparepart);?>
                                    </div>
                                    <div class="small-4 columns">
                                        <span class="prefix">Brand </span>
                                    </div>
                                    <div class="small-8 columns">

                                        <?php echo CHtml::dropDownlist('brand', $brand, CHtml::listData(Brand::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Brand --')); ?>
                                    </div>
                                    */?>
                                    <div class="small-4 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name'=>'tanggal',
                                                'options'=>array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>true,
                                                    'placeholder'=>'Pilih Tanggal',
                                                ),
                                            ));
                                        ?>
                                        <p><em>jika tanggal tidak di pilih default semua transaksi di bulan sekarang.</em></p>
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
                        <?php //echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
                       
                      <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
                        <?php echo CHtml::submitButton('Body Repair', array('name' => 'ExportExcelBody')); ?>
                        <?php echo CHtml::submitButton('General Repair', array('name' => 'ExportExcelGeneral')); ?>
                    </div>
					
					
                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

				</div>

				<hr />

				<div class="relative">
					<div class="reportDisplay">
					</div>
					<?php //$this->renderPartial('_laporanPenjualan', array('transactions'=>$transactions,'tanggal_mulai'=>$tanggal_mulai, 'tanggal_sampai'=>$tanggal_sampai,'branch'=>$branch)); ?>
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