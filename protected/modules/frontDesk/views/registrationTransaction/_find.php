<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registration-transaction-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form'),
        )
    );
    ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <?php //Yii::app()->clientScript->registerCoreScript('jquery.yiigridview'); ?>
    <div class="row">
        <div class="large-12 columns">
<!--            <label>Find By : </label>-->
            <?php $choice = array('2' => 'Vehicle');
            echo $form->radioButtonList($model, 'choice', $choice,
                array(
                    'separator' => ' ',
                    'labelOptions' => array('style' => 'display:inline'), // add this code
                    'onchange' => '	
			if($(this).val() == 1)
			{
				$( "#customer" ).show();
				$( "#vehicle" ).hide();
			} 
			else{

				$( "#vehicle" ).show();
				$( "#customer" ).hide();
			}
			ClearFields();
			$( "#customerData" ).empty();
			$( "#vehicleData" ).empty();
			
			'
                )); ?>
        </div>
    </div>

    <div class="row">
        <div class="medium-6 columns">
<!--            <div id="customer" class="hide">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Customer</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-8 columns">
                                    <?php /*echo $form->hiddenField($model, 'customer_id'); ?>
                                    <?php echo $form->textField($model, 'customer_name', array(
                                        'placeholder' => 'Customer Name',
                                        'onclick' => 'jQuery("#customer-dialog").dialog("open"); return false;',
                                        'value' => $model->customer_id != null ? $model->customer->name : '',
                                    )); ?>

                                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'customer-dialog',
                                            // additional javascript options for the dialog plugin
                                            'options' => array(
                                                'title' => 'Customer',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )
                                    );
                                    ?>

                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'customer-grid',
                                            // 'dataProvider'=>$customerDataProvider,
                                            'dataProvider' => $customer->search(),
                                            'filter' => $customer,
                                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                            'pager' => array(
                                                'cssFile' => false,
                                                'header' => '',
                                            ),
                                            'selectionChanged' => 'js:function(id){
											jQuery("#RegistrationTransaction_customer_id").val(jQuery.fn.yiiGridView.getSelection(id));
											jQuery("#customer-dialog").dialog("close");
											jQuery.ajax({
												type: "POST",
												dataType: "JSON",
												url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
												data: $("form").serialize(),
												success: function(data) {
													jQuery("#RegistrationTransaction_customer_name").val(data.name);

													$.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('customerData',
                                                    array('customerId' => '')) . '"+$("#RegistrationTransaction_customer_id").val(),
														data: $("form").serialize(),
														success: function(html) {
															$("#customerData").html(html);	

														},
													});

												},
											});

											jQuery("#customer-grid").find("tr.selected").each(function(){
												$(this).removeClass( "selected" );
											});
										}',
                                            'columns' => array(
                                                //'id',
                                                //'code',
                                                'name',
                                                'customer_type',
                                                array(
                                                    'name' => 'plate_number',
                                                    'value' => '$data->getPlateNumber()',
                                                    'type' => 'raw'
                                                ),
                                                'email',
                                            ),
                                        )
                                    );
                                    ?>

                                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                </div>

                                <div class="small-2 columns">
                                    <?php echo CHtml::button('GO', array(
                                            'id' => 'detail-button',
                                            'name' => 'Detail',
                                            'class' => 'button extra left ',
                                            'onclick' => ' 
										var type = $("#RegistrationTransaction_choice input[type=\'radio\']:checked").val();
											//alert(type);
										var cust  = $("#RegistrationTransaction_customer_id").val();
										window.location.href = "create?type="+type+"&id="+cust;
										'
                                        )
                                    );
                                    ?>
                                </div>

                                <div class="small-2 columns">
                                    <a class="button cbutton expand"
                                       href="<?php echo Yii::app()->baseUrl . '/master/customer/create';*/ ?>"><span
                                                class="fa fa-plus"></span>Add</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

            <div id="vehicle">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">Vehicle</label>
                        </div>
                        <div class="small-8 columns">
                            <div class="row">
                                <div class="small-10 columns">
                                    <?php echo $form->hiddenField($model, 'vehicle_id'); ?>
                                    <?php echo $form->textField($model, 'plate_number', array(
                                        'placeholder' => 'Plate Number',
                                        'onclick' => 'jQuery("#vehicle-dialog").dialog("open"); return false;',
                                        'value' => $model->vehicle_id != null ? $model->vehicle->plate_number : '',
                                    )); ?>

                                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'vehicle-dialog',
                                            'options' => array(
                                                'title' => 'Vehicle',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )
                                    );
                                    ?>

                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'vehicle-grid',
                                            // 'dataProvider'=>$vehicleDataProvider,
                                            'dataProvider' => $vehicleDataProvider,
                                            'filter' => $vehicle,
                                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                            'pager' => array('cssFile' => false, 'header' => ''),
                                            'selectionChanged' => 'js:function(id) {
                                                jQuery("#RegistrationTransaction_vehicle_id").val(jQuery.fn.yiiGridView.getSelection(id));
                                                jQuery("#vehicle-dialog").dialog("close");
                                                jQuery.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxVehicle', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        jQuery("#RegistrationTransaction_plate_number").val(data.plate);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "' . CController::createUrl('vehicleData', array('vehicleId' => '')) . '"+data.id,
                                                            data: $("form").serialize(),
                                                            success: function(html) {
                                                                $("#vehicleData").html(html);	
                                                            },
                                                        });
                                                    },
                                                });
    
                                                jQuery("#vehicle-grid").find("tr.selected").each(function() {
                                                    $(this).removeClass("selected");
                                                });
                                            }',
                                            'columns' => array(
                                                //'id',
                                                //'code',
                                                'plate_number',
                                                array(
                                                    'header' => 'Car Make',
                                                    'name' => 'car_make',
                                                    'value' => '($data->carMake ? $data->carMake->name : \'\')'
                                                ),
                                                array(
                                                    'header' => 'Car Model',
                                                    'name' => 'car_model',
                                                    'value' => '($data->carModel ? $data->carModel->name : \'\')'
                                                ),
                                                array(
                                                    'header' => 'Color',
                                                    'name' => 'color',
                                                    'value' => '$data->getColor($data,"color_id")',
                                                    'filter' => CHtml::dropDownList(
                                                        'Vehicle[color_id]',
                                                        'color',
                                                        CHtml::listData(Colors::model()->findAll(), 'id', 'name'),
                                                        array('class' => 'form-control', 'empty' => '--Select Color--')
                                                    ),
                                                ),
                                                array(
                                                    'header' => 'Customer',
                                                    'name' => 'customer_id',
                                                    'value' => '$data->customer->name',
                                                    'filter' => CHtml::textField('CustomerCompany', $customerCompany),
                                                ),
                                            ),
                                        )
                                    );
                                    ?>

                                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                </div>
                                <div class="small-2 columns">
                                    <?php echo CHtml::button('GO', array(
                                            'id' => 'vehicle-button',
                                            'name' => 'Vehicle',
                                            'class' => 'button extra left',
                                            'onclick' => ' 
										var type = $("#RegistrationTransaction_choice input[type=\'radio\']:checked").val();
											//alert(type);
										var cust  = $("#RegistrationTransaction_vehicle_id").val();
										window.location.href = "create?type="+type+"&id="+cust;
										'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="small-6 columns">
                        <a class="button cbutton expand"
                           href="<?php echo Yii::app()->baseUrl . '/master/vehicle/create'; ?>">
                            <span class="fa fa-plus"></span>Add New Vehicle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="medium-12 columns">
            <div id="customerData"></div>
        </div>
        <div class="medium-12 columns">
            <div id="vehicleData"></div>
        </div>
    </div>
    <script>
        function ClearFields() {
            $('#customer').find('input:text').val('');
            $('#vehicle').find('input:text').val('');
            //$('#requestDetail').find('input:text').val('');
        }
    </script>


    <?php $this->endWidget(); ?>

</div><!-- form -->