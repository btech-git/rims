<h3>Update Permintaan Harga</h3>

<div id="maincontent">
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'product-pricing-request-form',
            'enableAjaxValidation' => false,
        )); ?>
        <?php echo $form->errorSummary($model); ?>

        <hr />

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <div class="row">
            <div class="medium-12 columns">
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Nama Barang'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'product_name')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Untuk Kendaraan'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle_name')); ?>
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
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Tanggal Permintaan'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'request_date')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Merk'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'brand_name')); ?>
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
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Branch Request'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'branchIdRequest.code')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Tahun Produksi'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'production_year')); ?>
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
                                    <label class="prefix"><?php echo $form->labelEx($model, 'User Request'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'userIdRequest.username')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Kategori'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'category_name')); ?>
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
                                    <label class="prefix"><?php echo $form->labelEx($model, 'quantity'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'quantity')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Rekomendasi Harga'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextField($model, 'recommended_price'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row"><div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Catatan'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'request_note')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($model, 'Catatan'); ?></label>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextArea($model, 'reply_note', array('rows' => 5)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />

        <div style="text-align: center">
            <h2>Uploaded Image</h2>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/images/product_pricing_request/' . $model->id . '.' . $model->extension, "image", array("width" => "30%")); ?>  
        </div>

        <hr />

        <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'SubmitButton')); ?>
        </div>

        <?php echo IdempotentManager::generate(); ?>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>