<div class="wide form" id="advSearch">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'transaction_number', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'transaction_number'); ?>
                    </div>
                </div>
            </div>


            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'request_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'request_date',
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Tanggal Permintaan'
                            ),
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', array(
                            'Draft' => 'Draft',
                            'Approved' => 'Approved',
                        ), array('prompt' => 'All',));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'vehicle_car_make_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'vehicle_car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
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

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'vehicle_car_model_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div id="car_model">
                            <?php echo CHtml::activeDropDownList($model, 'vehicle_car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array(
                                'condition' => 'car_make_id = :car_make_id',
                                'params' => array(':car_make_id' => $model->vehicle_car_make_id),
                                'order' => 'name',
                            )), 'id', 'name'), array(
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

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'vehicle_car_sub_model_id', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div id="car_sub_model">
                            <?php echo CHtml::activeDropDownList($model, 'vehicle_car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(array(
                                'condition' => 'car_make_id = :car_make_id',
                                'params' => array(':car_make_id' => $model->vehicle_car_make_id),
                                'order' => 'name'
                            )), 'id', 'name'), array('empty' => '-- All --')); ?>
                        </div>
                    </div>
                </div>
            </div>	

            <div class="row buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->