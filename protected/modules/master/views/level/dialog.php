
 <div class="clearfix page-action">
<!-- begin FORM -->
 <br>
<div class="form">

   <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'level-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'action'=>$model->isNewRecord==1?Yii::app()->createUrl('/master/level/create'):Yii::app()->createUrl('/master/level/update&id='.$model->id),
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
'validateOnSubmit'=>true,
),
));
	
 ?>
 <hr>
   <p class="note">Fields with <span class="required">*</span> are required.</p>
	
    <input type="hidden" id ="data_level" value="" />
    <input type="hidden" id ="data_level_name" value="" />
<div class="row">
    <div class="small-12 medium-6 columns">

         
		 <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix"><?php echo $form->labelEx($model,'name'); ?></label>
                </div>
                <div class="small-8 columns">
				    <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
					<?php echo $form->error($model,'name'); ?>
				</div>
            </div>
         </div>
		 
	</div>
</div>
   </div>

   <hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>
</div>
<script type="text/javascript">
//$(document).ready(function(){\
$(document).ready(function() {
	
	if($("#data_level_name").val()!='') {
			$("#Level_name").val($(this).parent().siblings().children("a").text()); 
			return false;
	}
	
});
</script>