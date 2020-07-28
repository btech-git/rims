<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */
$this->breadcrumbs=array(
	'Transaction Request Orders'=>array('admin'),
	'Step 1'=>array('step1'),
	'Step 2',
	);

?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'transaction-purchase-order-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); ?>
		<?php //echo $form->textField($model,'supplier_id'); ?>

		<div class="row">
			<div class="small-12 medium-12 columns">
				<?php 
				$this->widget('ext.groupgridview.GroupGridView', array(
					'id'=>'transaction-request-order-detail-grid',
					'dataProvider'=>$modelDetail,
					// 'filter'=>$modelDetail,
					'template' => '{items}<!--<div class="clearfix">{summary}{pager}</div>-->',
					'pager'=>array(
						'cssFile'=>false,
						'header'=>'',
						),
				    'mergeColumns' => array('supplier_id'),
				    'extraRowTotals' => function($data, $row, &$totals) {
				          if(!isset($totals['count'])) $totals['count'] = 0;
				          $totals['count']++;
				    },
					'columns'=>array(
						// 'id',
						array( 
							'header'=>'No.', 
							'value'=>'$row+1 . CHtml::hiddenField("TransactionPurchaseOrder[supplier_id][]", $data->supplier_id, array("id"=>"idTextField"))',
							'type'=>'raw', 
						),
						array(
							'name'=>'supplier_id',
							'value'=>'$data->supplier->name '
						),
						array(
							'name'=>'request_order_id',
							'value'=>'$data->requestOrder->request_order_no'
						),
						array(
							'name'=>'product_id',
							'value'=>'$data->product->name'
						),
						'quantity',
						'unit_price',
						'total_price',
						// 'main_branch_id',
						// 'requestOrder.main_branch_id',
						array(
							'header'=>'Requester Branch',
							'value'=>'$data->requestOrder->requesterBranch->name',
						),
						array(
							'header'=>'PO',
							'name'=>'supplier_id',
							'value'=>'"Purchase Order for ".$data->supplier->name',
				            'type'=>'raw',
						),
						// 'supplier_id',
						// 'unit_id',

						),
						)); ?>
				<?php /*<div class="row">
					<div class="small-12 medium-6">
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
								  <label class="prefix"><?php echo $form->labelEx($model,'main_branch_id'); ?></label>
								  </div>
								<div class="small-8 columns">
								<?php echo $form->dropDownlist($model,'main_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]','class'=>'required')); ?>
									<?php echo $form->error($model,'main_branch_id'); ?>
								</div>
							</div>
					 	</div>						
					 	<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
								  <label class="prefix"><?php echo $form->labelEx($model,'requester_branch_id'); ?></label>
								  </div>
								<div class="small-8 columns">
								<?php echo $form->dropDownlist($model,'requester_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]','class'=>'required')); ?>
									<?php echo $form->error($model,'requester_branch_id'); ?>
								</div>
							</div>
					 	</div>						
					</div>
				</div>*/?>
				<div class="button-group">
					<?php //echo CHtml::link('Back',array('step1'),array('class'=>'tiny button cbutton')); ?>
					<?php echo CHtml::button("Back",array("id"=>"btnBack", 'class'=>'button cbutton')); ?>
					<?php echo CHtml::button("Create PO",array("id"=>"btnCreate", 'class'=>'button cbutton')); ?>
					<?php //echo CHtml::submitButton('Create PO', array('class'=>'button cbutton')); ?>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</div>

<?php
// Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl . '/js/vendor/jquery.validate.min.js',CClientScript::POS_END );
Yii::app()->clientScript->registerScript('centang','

/*
	$("#transaction-purchase-order-form").validate({
	    messages: {
	    TransactionPurchaseOrder_main_branch_id: {
	    	required: "Please select an option from the list",
	    },
	    TransactionPurchaseOrder_requester_branch_id: {
	    	required: "Please select an option from the list",
	    },
	    }
	});
*/

	$("#btnBack").click(function(){
        window.location.href = "'.CHtml::normalizeUrl(array('compare/step1')).'";
    });
');
