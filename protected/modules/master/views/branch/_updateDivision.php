		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Division </label>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeHiddenField($model,'division_id'); ?>
						<?php $division = Division::model()->findByPK($model->division_id); ?>
						<?php echo CHtml::activeTextField($model,'division_name',array('value'=>$model->division_id != '' ? $division->name : '','readonly'=>true )); ?>
					</div>
				</div>			
			</div>
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix">Email </label>
					</div>
					<div class="small-8 columns">
						
						<?php echo CHtml::activeTextField($model,'email',array('value'=>$model->division_id!= '' ? $model->email : '', )); ?>
						</div>
				</div>			
			</div>

			<div class="field buttons text-center">
				
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			 
			  <?php //echo "test"; ?>
			</div>