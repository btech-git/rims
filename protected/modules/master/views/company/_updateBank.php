		
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo CHtml::activeLabelEx($model,'account_no',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeHiddenField($model,'bank_id'); ?>
						<?php echo CHtml::activeTextField($model,'bank_name',array('size'=>60,'value'=> $model->bank_id != "" ? $model->bank->name : '','onclick'=>'jQuery("#bank-dialog").dialog("open"); return false;')); ?>
						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'bank-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Bank',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
						),));
					?>

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'bank-grid',
						'dataProvider'=>$bankDataProvider,
						'filter'=>$bank,
						// 'summaryText'=>'',
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'selectionChanged'=>'js:function(id){
							$("#bank-dialog").dialog("close");
							$.ajax({
								type: "POST",
								dataType: "JSON",
								url: "' . CController::createUrl('ajaxBank', array()) .'/id/"+$.fn.yiiGridView.getSelection(id),
								data: $("form").serialize(),
								success: function(data) {
									$("#CompanyBank_bank_id").val(data.id);
									$("#CompanyBank_bank_name").val(data.name);
									
								},
							});
							$("#bank-grid").find("tr.selected").each(function(){
							   $(this).removeClass( "selected" );
							});
						}',
						'columns'=>array(
							//'id',
							'code',
							'name'
							
						),
					));?>
					<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo CHtml::activeLabelEx($model,'account_name',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
							<?php echo CHtml::activeTextField($model,'account_name',
								array(
									//'size'=>15,
									//'maxlength'=>10,
					        'value' => $model->id == "" ? '': $model->account_name,
					        'placeholder' => 'Account Name',
							)); 

							?>
						<?php //echo $form->error($model,'customer_id'); ?>
					</div>
				</div>			
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo CHtml::activeLabelEx($model,'account_no',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
							<?php echo CHtml::activeTextField($model,'account_no',
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $model->id == "" ? '': $model->account_no,
			        'placeholder' => 'Account Number',
						)); 

					?>
						<?php //echo $form->error($model,'customer_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo CHtml::activeLabelEx($model,'swift_code',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
							<?php echo CHtml::activeTextField($model,'swift_code',
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $model->id == "" ? '': $model->account_no,
			        'placeholder' => 'Swift Code',
						)); 

					?>
						<?php //echo $form->error($model,'customer_id'); ?>
					</div>
				</div>			
			</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo CHtml::activeLabelEx($model,'coa_id',array('class'=>'prefix'));?>
					</div>
					<div class="small-8 columns">
						<?php echo CHtml::activeHiddenField($model,'coa_id'); ?>
						<?php echo CHtml::activeTextField($model,'coa_name',array('size'=>60,'readonly'=>true,'value'=> $model->coa_id != "" ? $model->coa->name : '','onclick'=>'jQuery("#coa-dialog").dialog("open"); return false;')); ?>
						<?php echo CHtml::activeTextField($model,'coa_code',array('size'=>60,'readonly'=>true,'value'=> $model->coa_id != "" ? $model->coa->code : '')); ?>
						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'coa-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Coa',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
						),));
					?>

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'coa-grid',
						'dataProvider'=>$coaDataProvider,
						'filter'=>$coa,
						// 'summaryText'=>'',
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'selectionChanged'=>'js:function(id){
							$("#coa-dialog").dialog("close");
							$.ajax({
								type: "POST",
								dataType: "JSON",
								url: "' . CController::createUrl('ajaxCoa', array()) .'/id/"+$.fn.yiiGridView.getSelection(id),
								data: $("form").serialize(),
								success: function(data) {
									$("#CompanyBank_coa_id").val(data.id);
									$("#CompanyBank_coa_name").val(data.name);
									$("#CompanyBank_coa_code").val(data.code);
									
								},
							});
							$("#coa-grid").find("tr.selected").each(function(){
							   $(this).removeClass( "selected" );
							});
						}',
						'columns'=>array(
							//'id',
							'code',
							'name'
							
						),
					));?>
					<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
					</div>
				</div>			
			</div>


			
		
			<div class="field buttons text-center">
				
			  <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton',)); ?>
			 
			  <?php //echo "test"; ?>
			</div>
