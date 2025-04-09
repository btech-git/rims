<?php

?>
<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-6 columns">
                                    <span class="prefix">Tahun </span>
                                </div>

                                <div class="small-6 columns">
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
                                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-6 columns">
                                    <span class="prefix">Master Category</span>
                                </div>

                                <div class="small-6 columns">
                                    <?php echo CHtml::dropDownList('MasterCategoryId', $masterCategoryId, CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                    )); ?>
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

            <div style="font-weight: bold; text-align: center">
                <div style="font-size: larger">Laporan Product Sub Master Category Statistics</div>
                <div><?php echo CHtml::encode($year); ?></div>
            </div>

            <br />

            <?php $monthList = array(
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec',
            ); ?>

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'yearlyStatistics' => $yearlyStatistics,
                    'year' => $year,
                    'monthList' => $monthList,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>