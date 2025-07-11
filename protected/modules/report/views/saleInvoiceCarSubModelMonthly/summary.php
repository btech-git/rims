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
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    <?php /*list($yearNow, $monthNow) = explode('-', $yearMonthNow); ?>
                                    <?php $currentYear = intval($yearNow); ?>
                                    <?php $currentMonth = intval($monthNow); ?>
                                    <?php $yearMonthRange = array(); ?>
                                    <?php for ($i = 0; $i < 36; $i++): ?>
                                        <?php $month = str_pad($currentMonth, 2, '0', STR_PAD_LEFT); ?>
                                        <?php $yearMonthRange[$currentYear . '-' . $month] = date('F', mktime(null, null, null, $currentMonth)) . ' ' . $currentYear; ?>
                                        <?php $currentMonth--; ?>
                                        <?php if ($currentMonth === 0): ?>
                                            <?php $currentMonth = 12; ?>
                                            <?php $currentYear--; ?>
                                        <?php endif; ?>
                                    <?php endfor;*/ ?>

<!--                                    <div class="small-8 columns">
                                        <?php //echo CHtml::dropDownList('YearMonth', $yearMonth, $yearMonthRange); ?>
                                    </div>-->
                                    
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

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'year' => $year,
                        'month' => $month,
                        'invoiceVehicleInfo' => $invoiceVehicleInfo,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
