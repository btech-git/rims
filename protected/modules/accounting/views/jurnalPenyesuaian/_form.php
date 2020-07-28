<?php
/* @var $this JurnalPenyesuaianController */
/* @var $model JurnalPenyesuaian */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jurnal-penyesuaian-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'transaction_number'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'transaction_number',array('size'=>50,'maxlength'=>50, 'readonly' => true)); ?>
				<?php echo $form->error($model,'transaction_number'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'transaction_date'); ?>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'transaction_date'); ?>
				<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "transaction_date",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeMonth'=>true,
        								 'changeYear'=>true,
        								 'yearRange'=>'1900:2020'
                     ),
                      'htmlOptions'=>array(
                      	'value'=>date('Y-m-d'),
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                        ),
                 ));
                ?>
				<?php echo $form->error($model,'transaction_date'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'coa_biaya_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->hiddenField($model,'coa_biaya_id'); ?>
				<?php echo $form->textField($model,'coa_biaya_name',array('readonly'=>true,'onclick'=>'jQuery("#coa-biaya-dialog").dialog("open"); return false;','value'=>$model->coa_biaya_id!=""?$model->coaBiaya->name:'')); ?>
				<?php echo $form->textField($model,'coa_biaya_code',array('readonly'=>true,'value'=>$model->coa_biaya_id!=""?$model->coaBiaya->code:'')); ?>
				<?php echo $form->error($model,'coa_biaya_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'coa_akumulasi_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->hiddenField($model,'coa_akumulasi_id'); ?>
				<?php echo $form->textField($model,'coa_akumulasi_name',array('readonly'=>true,'onclick'=>'jQuery("#coa-akumulasi-dialog").dialog("open"); return false;','value'=>$model->coa_akumulasi_id!=""?$model->coaAkumulasi->name:'')); ?>
				<?php echo $form->textField($model,'coa_akumulasi_code',array('readonly'=>true,'value'=>$model->coa_akumulasi_id!=""?$model->coaAkumulasi->code:'')); ?>
				<?php echo $form->error($model,'coa_akumulasi_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'amount'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'amount'); ?>
			</div>
		</div>
	</div>

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'status'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'status',array('size'=>30,'maxlength'=>30,'readonly'=>true,'value'=>$model->isNewRecord ?'Draft':$model->status)); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'branch_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php //echo $form->textField($model,'branch_id',array('readonly'=>true)); ?>
				<?php echo $form->dropDownlist($model,'branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
				<?php echo $form->error($model,'branch_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'user_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'user_id',array('value'=>$model->isNewRecord ?  Yii::app()->user->getId() : $model->user_id,'readonly'=>true)); ?>
				<?php echo $form->error($model,'user_id'); ?>
			</div>
		</div>
	</div>		

		<div class="field buttons text-center">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
		</div>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<!--COA Biaya-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'coa-biaya-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'COA Biaya',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
		),));
	?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-biaya-grid',
		'dataProvider'=>$coaBiayaDataProvider,
		'filter'=>$coaBiaya,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#JurnalPenyesuaian_coa_biaya_id").val($.fn.yiiGridView.getSelection(id));
			$("#coa-biaya-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#JurnalPenyesuaian_coa_biaya_code").val(data.code);
					$("#JurnalPenyesuaian_coa_biaya_name").val(data.name);
					
					
				},
			});
			$("#coa-biaya-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
			'normal_balance',
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<!--COA Akumulasi-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'coa-akumulasi-dialog',
		// additional javascript options for the dialog plugin
		'options' => array(
			'title' => 'COA Akumulasi',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
		),));
	?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'coa-akumulasi-grid',
		'dataProvider'=>$coaAkumulasiDataProvider,
		'filter'=>$coaAkumulasi,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
		   'cssFile'=>false,
		   'header'=>'',
		),
		'selectionChanged'=>'js:function(id){
			$("#JurnalPenyesuaian_coa_akumulasi_id").val($.fn.yiiGridView.getSelection(id));
			$("#coa-akumulasi-dialog").dialog("close");
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "' . CController::createUrl('ajaxCoa', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
				data: $("form").serialize(),
				success: function(data) {
					
					$("#JurnalPenyesuaian_coa_akumulasi_code").val(data.code);
					$("#JurnalPenyesuaian_coa_akumulasi_name").val(data.name);
					
					
				},
			});
			$("#coa-akumulasi-grid").find("tr.selected").each(function(){
               $(this).removeClass( "selected" );
            });
		}',
		'columns'=>
		//$coumns
		array(
			'name',
			'code',
			'normal_balance',
		),
	)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>