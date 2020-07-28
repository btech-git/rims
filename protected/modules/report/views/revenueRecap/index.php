<?php 
    $this->breadcrumbs=
    array(
        'Report',
        'Revenue Recap',
    ); 
?>
<?php 
    $years = [];
    for ($i=date("Y"); $i >= 2016; $i--) { 
        $years[$i] = $i; 
    }
    // var_dump($years);

?>
<div id="maincontent">
    <div class="row">
        <div class="small-12 medium-12 columns">
            <h1 class="report-title">Revenue Recap Report</h1>
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
                                    <?php /*<div class="small-4 columns">
                                        <span class="prefix">Services</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('type', '', 
                                        array('--' => '-- Pilih Service --'));?>
                                    </div>*/?>
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                    <div class="small-8 columns">

                                        <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>

                                    <div class="small-4 columns">
                                        <span class="prefix">Tahun </span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('tahun',$year, $years, array('empty'=>'-- Pilih Tahun --')); ?>
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
						<?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
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
