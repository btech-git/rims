<?php
/* @var $this LevelController */
/* @var $model Level */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/level/admin';?>"><span class="fa fa-th-list"></span>Manage Level</a>
<h1><?php if($model->isNewRecord){ echo "New Level"; }else{ echo "Update Level";}?></h1>
<!-- begin FORM -->

<div class="form">

   <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'level-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
 <hr>
   <p class="note">Fields with <span class="required">*</span> are required.</p>
	
   
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

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<label class="prefix"><?php echo $form->labelEx($model,'status'); ?></label>  
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($model, 'status', array('Active' => 'Active',
						'Inactive' => 'Inactive', )); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			</div>
		 
	</div>
<?php /*
	<div class="small-12 medium-5b columns">

<!-- begin RIGHT -->

<a class="button extra right" href="<?php echo Yii::app()->baseUrl.'/master/level/create';?>"><span class=""></span>Add Detail</a>
<h2>Position</h2>
<div class="grid-view">
	<table class="items">
	<thead>
	<tr>
		<th><a href="#" class="sort-link">Divisi</a></th>
		<th><a href="#" class="sort-link">Position.</a></th>
		<th><a href="#" class="sort-link"></a></th>
	</tr>
	</thead>
	<tbody>
		<tr><td class="empty" colspan="3"><span class="empty">No results found.</span></td></tr>
	</tbody>
	</table>
	<div class="clearfix"></div><div style="display:none" class="keys"></div>
</div>


<div></div>

<!-- end RIGHT -->

      </div>
*/?>
   </div>

   <hr>
	<div class="field buttons text-center">
		  <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
<?php $this->endWidget(); ?>

</div>
</div>
