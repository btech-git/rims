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
                                    <div class="small-4 columns">
                                        <span class="prefix">Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('type', $type, 
                                        array('cashin' => 'Kas Masuk', 'cashout' => 'Kas Keluar'));?>
                                    </div>
                                    <div class="small-4 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-8 columns">
                                         <?php
                                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                'name'=>'tanggal',
                                                'value'=>date("Y-m-d"),
                                                'options'=>array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array(
                                                    'readonly'=>true,
                                                    'placeholder'=>'Pilih Tanggal',
                                                ),
                                            ));
                                            ?>
                                    </div>

                                 </div>
                            </div>
                           
                        </div>
                    </div>
					
                    <div class="clear"></div>
                    <div class="row buttons">
						<?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'ExportExcel')); ?>
                    </div>
					
                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

				</div>

			</div>
		</div>
	</div>
</div>
