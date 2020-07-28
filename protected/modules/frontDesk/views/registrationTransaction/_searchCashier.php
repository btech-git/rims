<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		)
	); 
	?>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<div class="field">
				<div class="row collapse">
					<div class="small-3 columns">
						<?php echo $form->label($model,'customer_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php //echo $form->textField($model,'customer_id'); ?>
						<?php echo $form->hiddenField($model, 'customer_id'); ?>
						<?php echo $form->textField($model,'customer_name',array('placeholder'=>'Customer Name',
							'onclick' => 'jQuery("#customer-dialog").dialog("open"); return false;',
							'value' => $model->customer_id != Null ? $model->customer->name : '',
							)
						);
						?>
					</div>
					<div class="small-1 columns">
						<?php echo CHtml::button('Clear', array(
							'id' => 'clear-button',
							'name' => 'Clear',
							'class'=>'button expand',
							'onclick' => ' 
							$("#RegistrationTransaction_customer_name").val("");
							$("#RegistrationTransaction_customer_id").val("");
							'
							)
						);
						?>
					</div>
				</div>
			</div>	


			<div class="field">
				<div class="row collapse">
					<div class="small-3 columns">
						<label class="prefix">From</label>
					</div>
					<div class="small-9 columns">
						<div class="row">
							<div class="medium-5 columns">

								<?php $attribute = 'transaction_date'; ?>
								<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
								'id'=>CHtml::activeId($model, $attribute.'_0'),
								'model'=>$model,
								'attribute'=>$attribute."[0]",
								'options'=>array('dateFormat'=>'yy-mm-dd'),
								)); ?>									
							</div>
							<div class="medium-7 columns">
								<div class="field">
								<div class="row collapse">
									<div class="small-2 columns">
										<label class="prefix">To</label>
									</div>
									<div class="small-10 columns">
									<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'id'=>CHtml::activeId($model, $attribute.'_1'),
									'model'=>$model,
									'attribute'=>$attribute."[1]",
									'options'=>array('dateFormat'=>'yy-mm-dd'),
									)); ?>									

									</div>
								</div>
							</div>

							</div>
						</div>
					</div>
				</div>
			</div>

			<?php /*
			// Date range search inputs
			$attribute = 'transaction_date';
			for ($i = 0; $i <= 1; $i++)
			{
				echo "<label class=\"prefix\">" .($i == 0 ? Yii::t('main', 'From:') : Yii::t('main', 'To:'))."</label>";
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'id'=>CHtml::activeId($model, $attribute.'_'.$i),
					'model'=>$model,
					'attribute'=>$attribute."[$i]",
					'options'=>array('dateFormat'=>'yy-mm-dd'),
					)); 
			}*/
			?>

			<div class="field">
				<div class="row collapse">

			<div class="buttons text-right">
				<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
			</div>
			</div>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div><!-- search-form -->


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'customer-dialog',
					// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Customer',
		'autoOpen' => false,
		'width' => 'auto',
		'modal' => true,
		),)
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'customer-grid',
	'dataProvider'=>$customerDataProvider,
	'filter'=>$customer,
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
		'cssFile'=>false,
		'header'=>'',
		),
	'selectionChanged'=>'js:function(id){
		jQuery("#RegistrationTransaction_customer_id").val(jQuery.fn.yiiGridView.getSelection(id));
		jQuery("#customer-dialog").dialog("close");
		jQuery.ajax({
			type: "POST",
			dataType: "JSON",
			url: "' . CController::createUrl('ajaxCustomer', array('id'=> '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
			data: $("form").serialize(),
			success: function(data) {
				jQuery("#RegistrationTransaction_customer_name").val(data.name);



			},
		});

		jQuery("#customer-grid").find("tr.selected").each(function(){
			$(this).removeClass( "selected" );
		});
	}',
	'columns'=>array(
						//'id',
						//'code',
		'name',
		array(
			'header'=>'Customer Type', 
			'value'=>'$data->customer_type',
			'type'=>'raw',
			'filter'=>CHtml::dropDownList('Customer[customer_type]', $customer->customer_type, 
				array(
					''=>'All',
					'Individual'=>'Individual',
					'Company'=>'Company',

					)
				),
			),
						//'customer_type',
		'email',


		),
	)
);
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>