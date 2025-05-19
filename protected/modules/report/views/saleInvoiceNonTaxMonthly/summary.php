<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Periode</span>
                                </div>

                                <div class="small-4 columns">
                                    <?php echo CHtml::dropDownList('Month', $month, array(
                                        '01' => 'Jan',
                                        '02' => 'Feb',
                                        '03' => 'Mar',
                                        '04' => 'Apr',
                                        '05' => 'May',
                                        '06' => 'Jun',
                                        '07' => 'Jul',
                                        '08' => 'Aug',
                                        '09' => 'Sep',
                                        '10' => 'Oct',
                                        '11' => 'Nov',
                                        '12' => 'Dec',
                                    )); ?>
                                </div>

                                <div class="small-4 columns">
                                    <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch </span>
                                </div>
                                 <div class="small-8 columns">
                                      <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'monthlySaleSummary' => $monthlySaleSummary,
                    'year' => $year,
                    'month' => $month,
                    'branchId' => $branchId,
                )); ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>