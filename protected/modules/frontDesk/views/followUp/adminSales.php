<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($dataProvider->pagination->getCurrentPage(false) + 1) . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="tab reportTab">
    <div class="tabHead"><h1>Follow Up Customer</h1></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownlist($model, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Merk</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('CarMake', $carMake, CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                            'update' => '#car_model',
                                        )),
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
                                    <span class="prefix">Model</span>
                                </div>
                                <div class="small-8 columns" id="car_model">
                                    <?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
                                            'update' => '#car_sub_model',
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
                                    <span class="prefix">Sub Model</span>
                                </div>
                                <div class="small-8 columns" id="car_sub_model">
                                    <?php echo CHtml::dropDownList('CarSubModel', $carSubModel, CHtml::listData(VehicleCarSubModel::model()->findAll(), 'id', 'name'), array(
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
                                    <span class="prefix">Customer</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('CustomerName', $customerName); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tanggal </span>
                                </div>
                                <div class="small-4 columns">
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

                                <div class="small-4 columns">
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

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>

                <?php $this->renderPartial('_adminSales', array(
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="hide">
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>