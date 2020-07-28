<?php foreach ($supplier->picDetails as $i => $picDetail): ?>
	<?php //echo $i; ?>
		<!-- <div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label class="prefix">Code</label>
				</div>
				<div class="small-8 columns">
					<?php //echo CHtml::activeTextField($picDetail,"[$i]code",array('size'=>20,'maxlength'=>20)); ?>
					
					
				</div>
			</div>
		</div> -->
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

			<?php /*
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Company</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]company",array('size'=>30,'maxlength'=>30)); ?>
						
					</div>
				</div>
			</div>*/?>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">PIC Position</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]position",array('size'=>30,'maxlength'=>30)); ?>
						
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
			                        	$("#SupplierPic_'.$i.'_city_id").html(data);
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
						<label class="prefix">Email Personal</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]email_personal"); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Email Company</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activetextField($picDetail,"[$i]email_company",array('size'=>60,'maxlength'=>60)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">NPWP</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]npwp",array('size'=>20,'maxlength'=>20)); ?>
						
					</div>
				</div>
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Description</label>
					</div>
					<div class="small-8 columns">
		
						<?php echo CHtml::activeTextField($picDetail,"[$i]description",array('size'=>60,'maxlength'=>60)); ?>
						
					</div>
				</div>
			</div>
		
			<?php
				    echo CHtml::button('X', array(
				    	'class' =>'button extra right',
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemovePicDetail', array('id' => $supplier->header->id, 'index' => $i)),
					       	'update' => '#pic',
			      		)),
			     	));
		     	?>
			
			
			

	<?php endforeach; ?>

			