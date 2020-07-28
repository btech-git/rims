<?php
/* @var $this ConsignmentInHeaderController */
/* @var $model ConsignmentInHeader */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
        <div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'consignment_in_number', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'consignment_in_number',array('size'=>30,'maxlength'=>30));?>
                    </div>
                </div>
            </div>
	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'date_posting', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'date_posting');?>
                    </div>
                </div>
            </div>
	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'supplier_id', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'supplier_name');?>
                    </div>
                </div>
            </div>
        </div>	
        <div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'receive_branch', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($model, 'receive_branch', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </div>
            </div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'status_document', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'status_document',array('size'=>30,'maxlength'=>30));?>
                    </div>
                </div>
            </div>
	
            <div class="row buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class'=>'button cbutton'));?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->