<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Customer Name</label>
					</div>
					<div class="small-8 columns">
						<?php $customers = Customer::model()->findbyPk($model->customer_id); ?>
						<?php echo CHtml::activeHiddenField($model,'customer_id',array('size'=>30,'maxlength'=>30,'readonly'=>true)); ?>
						<?php echo CHtml::activeTextField($model,'customer_name',array('value'=>$customers->name,'readonly'=>true)); ?>
					</div>
				</div>
			</div>

<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">PIC </label>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_type',array('size'=>10,'maxlength'=>10)); ?>
						<?php echo CHtml::activeTextField($model,'name');?>
						<?php //echo $form->error($model,'customer_id'); ?>
					</div>
				</div>			
			</div>
		
			
			

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Name</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextArea($model,'address',array('rows'=>6, 'cols'=>50));; ?>
				
			</div>
		</div>			
	</div>

	<div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix">Province</label>
                </div>
                <div class="small-8 columns">
				    <?php //echo  CHtml::dropDownList($picDetail, 'province_id',  array('prompt' => 'Select',)); ?>
					<?php echo CHtml::activeDropDownList($model, 'province_id', CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Province--]',
				    			'onchange'=> '$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetCityPic') . '" ,
									data: $("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	$("#CustomerPic_city_id").html(data);
		                        	},
								});'
					)); ?>
					
				</div>
            </div>
         </div>
		 
		 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix">City</label>
                </div>
                <div class="small-8 columns">
				   
					<?php
							if($model->province_id == NULL)
							{
								echo CHtml::activeDropDownList($model,'city_id',array(),array('prompt'=>'[--Select City-]'));
							}
							else
							{
								echo CHtml::activeDropDownList($model,'city_id',CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$model->province_id)), 'id', 'name'),array());
							}
						?>
					
				</div>
            </div>
         </div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Zip code</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?>
				<?php //echo $form->error($model,'zipcode'); ?>
			</div>
		</div>			
	</div>
	
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Fax</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextField($model,'fax',array('size'=>20,'maxlength'=>20)); ?>
				<?php //echo $form->error($model,'fax'); ?>
			</div>
		</div>			
	</div>
	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Email</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
				<?php //echo $form->error($model,'email'); ?>
			</div>
		</div>			
	</div>
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Note</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::activeTextArea($model,'note',array('rows'=>6, 'cols'=>50));; ?>
				<?php //echo $form->error($model,'note'); ?>
			</div>
		</div>			
	</div>

	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Birthdate</label>
			</div>
			<div class="small-8 columns">
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			      	'model' => $model,
			         'attribute' => 'birthdate',
			         // additional javascript options for the date picker plugin
			         'options'=>array(
			         		'changeMonth'=>true,
									'changeYear'=>true,
									'yearRange'=>'1900:2020',
			            'dateFormat' => 'yy-mm-dd',

			         ),



			     ));
			    ?>
			</div>
		</div>			
	</div>
	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Status</label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeDropDownList($model, 'status', array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						
					</div>
				</div>
			</div>	
			<div class="field buttons text-center">
				
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			 
			  <?php //echo "test"; ?>
			</div>