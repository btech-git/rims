
<?php foreach ($customer->picDetails as $i => $picDetail): ?>
	<?php //echo $i; ?>
	
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">PIC Name</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]name",array('size'=>30,'maxlength'=>30)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Address</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextArea($picDetail,"[$i]address",array('rows'=>6, 'cols'=>50)); ?>
						
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
					<?php echo CHtml::activeDropDownList($picDetail, "[$i]province_id", CHtml::listData(Province::model()->findAll(), 'id', 'name'),array(
									'prompt' => '[--Select Province--]',
				    			'onchange'=> '$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxGetCityPicIndex') . '/index/'.$i.'" ,
									
									data: $("form").serialize(),
									success: function(data){
			                        	console.log(data);
			                        	$("#CustomerPic_'.$i.'_city_id").html(data);
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
							if($picDetail->province_id == NULL)
							{
								echo CHtml::activeDropDownList($picDetail,"[$i]city_id",array(),array('prompt'=>'[--Select City-]'));
							}
							else
							{
								echo CHtml::activeDropDownList($picDetail,"[$i]city_id",CHtml::listData(City::model()->findAllByAttributes(array('province_id'=>$picDetail->province_id)), 'id', 'name'),array());
							}
						?>
					
				</div>
            </div>
         </div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Zip Code</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]zipcode",array('size'=>10,'maxlength'=>10)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Fax</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]fax",array('size'=>20,'maxlength'=>20)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Email</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]email"); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">note</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextArea($picDetail,"[$i]note",array('rows'=>6, 'cols'=>50)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Birthdate</label>
					</div>
					<div class="small-8 columns">
		
						<?php //echo CHtml::activeTextField($picDetail,"[$i]birthdate",array('size'=>60,'maxlength'=>60)); ?>
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			      	'model' => $picDetail,
			         'attribute' => "[$i]birthdate",
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
						<?php echo CHtml::activeDropDownList($picDetail, "[$i]status", array('Active' => 'Active',
									'Inactive' => 'Inactive', )); ?>
						
					</div>
				</div>
			</div>	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  
					</div>
					<div class="small-8 columns">
						<?php
					    echo CHtml::button('X', array(
					    	'class' =>'button extra right',
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemovePicDetail', array('id' => $customer->header->id, 'index' => $i)),

						       	'update' => '#pic',
				      		)),
				     	));
			     	?>
						
					</div>
				</div>
			</div>	
			
			
			
			
			
			

	<?php endforeach; ?>

			