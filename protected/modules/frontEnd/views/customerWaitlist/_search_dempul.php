<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */
/* @var $form CActiveForm */
?>
<div class="wide form" style="border-bottom: 1px solid #CCC">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route."#timecounter"),
	'method'=>'get',
	'htmlOptions'=>array('id'=>'dempulForm'),
)); ?>
<div class="row">
	<div class="small-12 medium-6 columns">
	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix" >Customer</label>
			</div>
			<div class="small-8 columns">
				<input size="18" maxlength="18" value="<?= !empty($_GET['RegistrationTransaction']['customer_name'])?$_GET['RegistrationTransaction']['customer_name']:''?>" id="RegistrationTransaction_customer_name_dempul" name="RegistrationTransaction[customer_name]" type="text" onclick="jQuery('#customer-dialog').dialog('open'); return false;">
				<input type="hidden" name="RegistrationTransaction[tab_type]" value="3" id="tab_type">
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Customer Type</label>
			</div>
			<div class="small-8 columns">
				<select name="RegistrationTransaction[customer_type]">
				<option value="">[--Select Customer Type--]</option>
				<option value="Individual" <?= empty($_GET['RegistrationTransaction']['customer_type'])?'':($_GET['RegistrationTransaction']['customer_type'] == 'Individual')?'selected':'';?>>Individual</option>
				<option value="Company" <?= empty($_GET['RegistrationTransaction']['customer_type'])?'':($_GET['RegistrationTransaction']['customer_type'] == 'Company')?'selected':'';?>>Company</option>
				</select>
			</div>
		</div>
	</div>	
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Branch</label>
			</div>
			<div class="small-8 columns">
				<?php echo CHtml::dropDownList('RegistrationTransaction[branch_id]','',CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
	    						'prompt' => '[--Select Branch--]'
	    						)
	    					); 
	    					?>
			</div>
		</div>
	</div>	
	</div>
	<div class="small-12 medium-6 columns">
	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Transaction Date</label>
			</div>
			<div class="small-8 columns">
				<!-- <input size="18" maxlength="18" value="<?= !empty($_GET['RegistrationTransaction']['date_repair'])?$_GET['RegistrationTransaction']['date_repair']:''; ?>" name="RegistrationTransaction[date_repair]" type="text"> -->

				<?php
				/*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				    'name'=>'RegistrationTransaction[date_repair]',
				    // additional javascript options for the date picker plugin
				    'options'=>array(
				        'showAnim'=>'fold',
                        'dateFormat' => 'yy-mm-dd',
				    ),
				    'htmlOptions'=>array(
				    	'value' =>!empty($_GET['RegistrationTransaction']['date_repair'])?$_GET['RegistrationTransaction']['date_repair']:'',
				        // 'style'=>'height:20px;'
				    ),
				));*/?>

				<div class="row">
						<div class="medium-6 columns">
							<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							    'name'=>'RegistrationTransaction[transaction_date_from]',
							    // additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'fold',
			                        'dateFormat' => 'yy-mm-dd',
							    ),
							    'htmlOptions'=>array(
							    	'id'=>'dempul_transaction_date_0',
							    	'value' =>!empty($_GET['RegistrationTransaction']['transaction_date_from'])?$_GET['RegistrationTransaction']['transaction_date_from']:'',
							        // 'style'=>'height:20px;'
							    ),
							));?>
						</div>
						<div class="medium-6 columns">

							<?php
							$this->widget('zii.widgets.jui.CJuiDatePicker',array(
							    'name'=>'RegistrationTransaction[transaction_date_to]',
							    // additional javascript options for the date picker plugin
							    'options'=>array(
							        'showAnim'=>'fold',
							        'dateFormat' => 'yy-mm-dd',
							    ),
							    'htmlOptions'=>array(
							    	'id'=>'dempul_transaction_date_1',
							    	'value' =>!empty($_GET['RegistrationTransaction']['transaction_date_to'])?$_GET['RegistrationTransaction']['transaction_date_to']:'',
							        // 'style'=>'height:20px;'
							    ),
							));?>
						</div>
					</div>

			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Repair Type</label>
			</div>
			<div class="small-8 columns">
				<select name="RegistrationTransaction[repair_type]" >
				<option value="">[--Select Repair Type--]</option>
				<option value="GR"  <?= empty($_GET['RegistrationTransaction']['repair_type'])?'':($_GET['RegistrationTransaction']['repair_type'] == 'GR')?'selected':'';?>>General Repair</option>
				<option value="BR"  <?= empty($_GET['RegistrationTransaction']['repair_type'])?'':($_GET['RegistrationTransaction']['repair_type'] == 'BR')?'selected':'';?>>Body Repair</option>
				</select>
			</div>
		</div>
	</div>	

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<label class="prefix">Status</label>
			</div>
			<div class="small-8 columns">
				<?php 
					echo CHtml::dropDownList('RegistrationTransaction[status]', '', 
						array(
							''=>'All',
							'Registration'=>'Registration',
							'Pending'=>'Pending',
							'Available'=>'Available',
							'On Progress'=>'On Progress',
							'Finished'=>'Finished'
						), 
						array("style"=>"margin-bottom:0px;")
					);
				?>
			</div>
		</div>
	</div>	

	<div class="buttons text-right">
		<?php echo CHtml::submitButton('Search', 
			array( 
				'class'=>'button cbutton', 
				'id'=>'dempulBtn',
				'onclick'=>'$("#dempulDatas-transaction-grid").yiiGridView("update", {
						data: $("#dempulForm").serialize()
					});
					return false;'
				)
		); ?>
	</div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->