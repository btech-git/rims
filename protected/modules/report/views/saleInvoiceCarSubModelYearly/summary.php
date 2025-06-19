<?php
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
                                        <span class="prefix">Tahun </span>
                                    </div>

                                    <div class="small-8 columns">
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
                    
                    <div class="row">
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
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Model</span>
                                    </div>
                                    <div class="small-8 columns" id="car_model">
                                        <?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMake), array('order' => 'name')), 'id', 'name'), array(
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
                            'invoiceVehicleInfo' => $invoiceVehicleInfo,
                        'year' => $year,
                        'monthList' => $monthList,
                        'branchId' => $branchId,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
