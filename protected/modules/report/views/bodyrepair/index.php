<?php
$this->breadcrumbs = array(
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
                                                <div class="small-4 columns">
                                                    <span class="prefix">Tanggal </span>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                        'name' => 'tanggal',
                                                        'options' => array(
                                                            'dateFormat' => 'yy-mm-dd',
                                                        ),
                                                        'htmlOptions' => array(
                                                            'readonly' => true,
                                                            'placeholder' => 'Pilih Tanggal',
                                                        ),
                                                    )); ?>
                                                    <p><em>jika tanggal tidak di pilih default semua transaksi di bulan sekarang.</em></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="clear"></div>
                                <div class="row buttons">
                                    <?php echo CHtml::submitButton('Body Repair', array('name' => 'ExportExcelBody')); ?>
                                    <?php echo CHtml::submitButton('General Repair', array('name' => 'ExportExcelGeneral')); ?>
                                </div>

                                <?php echo CHtml::endForm(); ?>
                                <div class="clear"></div>
                            </div>

                            <hr />

                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>