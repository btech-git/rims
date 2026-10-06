<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/frontDesk/productPricingRequest/admin';  ?>"><span class="fa fa-th-list"></span>Manage</a>

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-pricing-request-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>

    <hr />
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($productPricingRequest->header); ?>

    <div class="row">
        <div class="medium-12 columns">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Make</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::activeDropDownList($productPricingRequest->header, "vehicle_car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                                    'prompt' => '[--Select Car Make--]',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                        'update' => '#car_model',
                                    )),
                                )); ?>
                                <?php echo $form->error($productPricingRequest->header,'vehicle_car_make_id');  ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Model</label>
                            </div>
                            <div class="small-8 columns" id="car_model">
                                <?php echo CHtml::activeDropDownList($productPricingRequest->header, "vehicle_car_model_id", CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                                    'prompt' => '[--Select Car Model--]',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
                                        'update' => '#car_sub_model',
                                    )),
                                )); ?>
                                <?php echo $form->error($productPricingRequest->header,'vehicle_car_model_id');  ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Car Sub Model</label>
                            </div>

                            <div class="small-8 columns" id="car_sub_model">
                                <?php echo $form->dropDownList($productPricingRequest->header, 'vehicle_car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                                    'prompt' => '[--Select Sub Model--]',
                                )); ?>
                                <?php echo $form->error($productPricingRequest->header, 'vehicle_car_sub_model_id'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Tahun Kendaraan'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($productPricingRequest->header, 'production_year'); ?>
                                <?php echo CHtml::error($productPricingRequest->header, 'production_year'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">VIN #</label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($productPricingRequest->header, 'vehicle_machine_number'); ?>
                                <?php echo CHtml::error($productPricingRequest->header, 'vehicle_machine_number'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Rangka #</label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextField($productPricingRequest->header, 'vehicle_frame_number'); ?>
                                <?php echo CHtml::error($productPricingRequest->header, 'vehicle_frame_number'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Catatan'); ?></label>
                            </div>

                            <div class="small-8 columns">
                                <?php echo CHtml::activeTextArea($productPricingRequest->header, 'request_note', array('rows' => 5)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Add Items', array(
            'onclick' => CHtml::ajax(array(
                'type' => 'POST',
                'url' => CController::createUrl('ajaxHtmlAddDetail', array('id' => $productPricingRequest->header->id)),
                'update' => '#detail_div',
            )),
        )); ?>
    </div>
    
    <br /><br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'productPricingRequest' => $productPricingRequest,
        )); ?>
    </div>

    <hr />

    <div style="text-align: center">
        <h2>Upload Image</h2>
        <?php echo CHtml::label('Foto Barang: ', FALSE); ?>
        <?php echo CHtml::fileField('file'); ?>
        <?php echo CHtml::error($productPricingRequest->header, 'file'); ?>
    </div>

    <br />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

<?php echo IdempotentManager::generate(); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
