<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */
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
						<?php echo $form->label($model,'transfer_request_no', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transfer_request_no',array('size'=>30,'maxlength'=>30));?>
                    </div>
                </div>
            </div>

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'transfer_request_date', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transfer_request_date');?>
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

	
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->label($model,'estimate_arrival_date', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'estimate_arrival_date');?>
                    </div>
                </div>
            </div>
        </div>	
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'requester_branch_id', array('class'=>'prefix'));?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'branch_name');?>
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