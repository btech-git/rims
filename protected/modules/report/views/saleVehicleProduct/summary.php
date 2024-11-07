<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $saleVehicleProductSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($saleVehicleProductSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
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
                                        <span class="prefix">Jumlah per Halaman</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
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
                                        <span class="prefix">Car Make</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($carMake, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#car-make-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#car-make-dialog").dialog("open"); return false; }',
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'car-make-dialog',
                                            'options' => array(
                                                'title' => 'Car Make',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )); ?>

                                        <div class="row">
                                            <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
                                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                                    'id'=>'car-make-grid',
                                                    'dataProvider'=>$carMakeDataProvider,
                                                    'filter'=>null,
                                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                                    'pager'=>array(
                                                        'cssFile'=>false,
                                                        'header'=>'',
                                                    ),
                                                    'selectionChanged'=>'js:function(id){
                                                        $("#' . CHtml::activeId($carMake, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                        $("#car-make-dialog").dialog("close");
                                                        if ($.fn.yiiGridView.getSelection(id) == "") {
                                                            $("#car_make_name").html("");
                                                        } else {
                                                            $.ajax({
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                url: "' . CController::createUrl('ajaxJsonCarMake') . '",
                                                                data: $("form").serialize(),
                                                                success: function(data) {
                                                                    $("#car_make_name").html(data.car_make_name);
                                                                },
                                                            });
                                                        }
                                                    }',
                                                    'columns'=>array(
                                                        'id',
                                                        'name',
                                                    ),
                                                )); ?>
                                            </div>
                                        </div>
                                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'car_make_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($carMake, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?> 

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

                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Mulai',
                                            ),
                                        )); ?>
                                    </div>

                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Sampai',
                                            ),
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
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="right"><?php echo ReportHelper::summaryText($saleVehicleProductSummary->dataProvider); ?></div>
                <br />
                <div class="right"><?php echo ReportHelper::sortText($saleVehicleProductSummary->dataProvider->sort, array('Name')); ?></div>
                <div class="clear"></div>

                <br />
        
                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'saleVehicleProductSummary' => $saleVehicleProductSummary,
                        'carMake' => $carMake,
                        'carMakeDataProvider' => $carMakeDataProvider,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'branchId' => $branchId,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
            
<br/>

<div class="right">
    <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $saleRetailProductSummary->dataProvider->pagination->itemCount,
        'pageSize' => $saleRetailProductSummary->dataProvider->pagination->pageSize,
        'currentPage' => $saleRetailProductSummary->dataProvider->pagination->getCurrentPage(false),
    ));*/ ?>
</div>
<div class="clear"></div>