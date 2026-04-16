<script type="text/javascript">
    $(document).ready(function () {
        $('.dateClass').live("keyup", function (e) {
            var Length=$(this).attr("maxlength");

            if ($(this).val().length >= parseInt(Length)){
                $(this).next('.dateClass').focus();
            }
        });
    }
</script>

<div class="form">
    <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($vehicleSystemCheck->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $vehicleSystemCheck->header,
                            'attribute' => "transaction_date",
                            'options' => array(
                                'minDate' => '-1W',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
//                                'value' => date('Y-m-d'),
                            ),
                        )); ?>
                        <?php echo CHtml::error($vehicleSystemCheck->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'branch.name')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Customer', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.customer.name')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Plat #', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.plate_number')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Warna', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.color.name')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Kendaraan', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.carSubModel.name')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('RG #', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.transaction_number')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('WO #', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.work_order_number')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Kilometer', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle_mileage')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Nomor Mesin', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.machine_number')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Nomor Rangka', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($vehicleSystemCheck->header, 'registrationTransaction.vehicle.frame_number')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php echo CHtml::hiddenField('ProductMode', ''); ?>
        <?php $this->renderPartial('_detailTire', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
        )); ?>
    </div>

    <hr />

    <div id="detail_div">
        <?php $this->renderPartial('_detailComponent', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
        )); ?>
    </div>

    <hr />
    
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Penjelasan Body Repair', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'body_repair_note'); ?>
                        <?php echo CHtml::error($vehicleSystemCheck->header, 'body_repair_note'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Rekomendasi Kondisi Kendaraan', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'vehicle_condition_recommendation'); ?>
                        <?php echo CHtml::error($vehicleSystemCheck->header, 'vehicle_condition_recommendation'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Rekomendasi Service Selanjutnya', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'next_service_recommendation'); ?>
                        <?php echo CHtml::error($vehicleSystemCheck->header, 'next_service_recommendation'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Periode / KM Service Selanjutnya', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($vehicleSystemCheck->header, 'next_service_kilometer'); ?>
                        <?php echo CHtml::error($vehicleSystemCheck->header, 'next_service_kilometer'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Ban',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $productDataProvider,
    'filter' => $product,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
        if ($("#ProductMode").val() === "1") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_front_left_before_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "2") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_front_left_after_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "3") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_front_right_before_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "4") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_front_right_after_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "5") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_rear_left_before_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "6") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_rear_left_after_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "7") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_rear_right_before_service') . '").val($.fn.yiiGridView.getSelection(id));
        } else if ($("#ProductMode").val() === "8") {
            $("#' . CHtml::activeId($vehicleSystemCheck->header, 'product_id_rear_right_after_service') . '").val($.fn.yiiGridView.getSelection(id));
        }
        $("#product-dialog").dialog("close");

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxProduct', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
            data: $("form").serialize(),
            success: function(data) {
                if ($("#ProductMode").val() === "1") {
                    $("#product_id_front_left_before_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "2") {
                    $("#product_id_front_left_after_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "3") {
                    $("#product_id_front_right_before_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "4") {
                    $("#product_id_front_right_after_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "5") {
                    $("#product_id_rear_left_before_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "6") {
                    $("#product_id_rear_left_after_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "7") {
                    $("#product_id_rear_right_before_service_span").html(data.name + " - " + data.tire_size);
                } else if ($("#ProductMode").val() === "8") {
                    $("#product_id_rear_right_after_service_span").html(data.name + " - " + data.tire_size);
                }
            },
        });
    }',
    'columns' => array(
        'name',
        'manufacturer_code',
        'production_year',
        array(
            'header' => 'Brand',
            'value' => 'CHtml::encode(CHtml::value($data, "brand.name"))',
        ),
        array(
            'header' => 'Sub Brand',
            'value' => 'CHtml::encode(CHtml::value($data, "subBrand.name"))',
        ),
        array(
            'header' => 'Sub Brand Series',
            'value' => 'CHtml::encode(CHtml::value($data, "subBrandSeries.name"))',
        ),
        array(
            'header' => 'Size',
            'value' => 'CHtml::encode(CHtml::value($data, "tireSize.tireName"))',
        ),
    )
)); ?>
<?php $this->endWidget(); ?>
    