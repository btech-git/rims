<div class="myForm">
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Customer</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::hiddenField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?>
                        <?php echo CHtml::textField('CustomerName', $customerName); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">KM</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownlist('StartMileage', $startMileage, array(
                            0 => '0 - 9.999',
                            10000 => '10.000 - 19.999',
                            20000 => '20.000 - 29.999',
                            30000 => '30.000 - 39.999',
                            40000 => '40.000 - 49.999',
                            50000 => '50.000 - 59.999',
                            60000 => '60.000 - 69.999',
                            70000 => '70.000 - 79.999',
                            80000 => '80.000 - 89.999',
                            90000 => '90.000 - 99.999',
                            100000 => '100.000 - 109.999',
                            110000 => '110.000 - 119.999',
                            120000 => '120.000 - 129.999',
                            130000 => '130.000 - 139.999',
                            140000 => '140.000 - 149.999',
                            150000 => '150.000 - 159.999',
                            160000 => '160.000 - 169.999',
                            170000 => '170.000 - 179.999',
                            180000 => '180.000 - 189.999',
                            190000 => '190.000 - 199.999',
                            200000 => '200.000 - 109.999',
                        ), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Plate #</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('PlateNumber', $plateNumber); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Merk</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownList('CarMake', $carMake, CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
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

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Model</span>
                    </div>
                    <div class="small-8 columns" id="car_model">
                        <?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
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

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Sub Model</span>
                    </div>
                    <div class="small-8 columns" id="car_sub_model">
                        <?php echo CHtml::dropDownList('CarSubModel', $carSubModel, CHtml::listData(VehicleCarSubModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Branch</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',)); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix"></span>
                    </div>
                    <div class="small-8 columns" id="car_model">
                    </div>
                </div>
            </div>
        </div>

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix"></span>
                    </div>
                    <div class="small-8 columns" id="car_sub_model">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Invoice</span>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'InvoiceStartDate',
                            'value' => $invoiceStartDate,
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
                            'name' => 'InvoiceEndDate',
                            'value' => $invoiceEndDate,
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

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Warranty</span>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'WarrantyStartDate',
                            'value' => $warrantyStartDate,
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
                            'name' => 'WarrantyEndDate',
                            'value' => $warrantyEndDate,
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

        <div class="medium-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Follow Up</span>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'FollowUpStartDate',
                            'value' => $followUpStartDate,
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
                            'name' => 'FollowUpEndDate',
                            'value' => $followUpEndDate,
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
        <?php if (Yii::app()->user->checkAccess('director')): ?>
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
        <?php endif; ?>
    </div>

    <?php echo CHtml::endForm(); ?>

    <div class="clear"></div>

</div> 