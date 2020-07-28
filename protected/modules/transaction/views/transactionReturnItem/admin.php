<?php
/* @var $this TransactionReturnItemController */
/* @var $model TransactionReturnItem */

$this->breadcrumbs=array(
	'Transaction Return Items'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TransactionReturnItem', 'url'=>array('admin')),
	array('label'=>'Create TransactionReturnItem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#transaction-sales-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
	
<div id="maincontent">
	<div class="clearfix page-action">
		<?php echo CHtml::link('<span class="fa fa-plus"></span>New Return Item', Yii::app()->baseUrl.'/transaction/transactionReturnItem/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionReturnItem.create"))) ?>
				
            <h1>Manage Transaction Return Item</h1>
			<div class="search-bar">
			<div class="clearfix button-bar">
  			<!--<div class="left clearfix bulk-action">
         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
  			<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
            </div><!-- search-form -->				
		</div>
		</div>

				<div class="grid-view">

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'transaction-return-item-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				'pager'=>array(
				   'cssFile'=>false,
				   'header'=>'',
				),
				'columns'=>array(
					array('name'=>'return_item_no', 'value'=>'CHTml::link($data->return_item_no, array("view", "id"=>$data->id))', 'type'=>'raw'),
					
					'return_item_date',
					'delivery_order_id',
					// 'recipient_id',
					// 'recipient_branch_id',
					array(
						'name'=>'customer_name',
						'value'=>'!empty($data->customer->name)?$data->customer->name:""'
					),
					array(
						'name'=>'recipient_id',
						'value'=>'!empty($data->user->username)?$data->user->username:""'
					),
					array(
						'name'=>'recipient_branch_id',
                        'filter' => CHtml::activeDropDownList($model, 'recipient_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
						'value'=>'$data->recipientBranch->name'
					),
					/*
					'request_type',
					'sent_request_id',
					'request_date',
					'estimate_arrival_date',
					'destination_branch',
					'sales_order_id',
					'customer_id',
					*/
					array(
						'class'=>'CButtonColumn',
						'template'=>'{edit}',
						'buttons'=>array(
						'edit' => array(
							'label'=>'edit',
							'url'=>'Yii::app()->createUrl("transaction/transactionReturnItem/update", array("id"=>$data->id))',
							'visible'=>'count(MovementInHeader::model()->findAllByAttributes(array("return_item_id"=>$data->id))) == 0 && Yii::app()->user->checkAccess("transaction.transactionReturnItem.update") && $data->status != "Rejected"'
						),
					),
				),
				),
			)); ?>
			</div>
		</div>
	</div>