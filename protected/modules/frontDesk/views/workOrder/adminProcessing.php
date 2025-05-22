<?php
Yii::app()->clientScript->registerScript('report', '
    $(".breadcrumbs").addClass("hide");
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Plate #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($model, 'plate_number'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
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
                                    <span class="prefix">Car Make</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($model, 'car_make_code', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => 
                                            CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                            'update' => '#car_model',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Car Model</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($model, 'car_model_code', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
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
                                    <span class="prefix">WO #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($model, 'work_order_number'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">WO Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($model, 'status', array(
                                        ''=>'-- All --',
    //                                    'Registration'=>'Registration',
    //                                    'Pending'=>'Pending',
                                        'Waitlist'=>'Waitlist',
                                        'Processing WO'=>'Processing WO',
                                        'Assigned'=>'Assigned',
                                        'Finished'=>'Finished',
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
                                    <span class="prefix">Type</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($model, 'repair_type', array(
                                        ''=>'-- All --',
                                        'GR'=>'GR',
                                        'BR'=>'BR',
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

            <div class="right"><?php echo ReportHelper::summaryText($dataProvider); ?></div>
            <br />
            <div class="right"><?php //echo ReportHelper::sortText($receivableSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
            <div class="clear"></div>
            <br />

            <div class="relative">
                <?php $this->renderPartial('_adminProcessing', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                )); ?>
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>