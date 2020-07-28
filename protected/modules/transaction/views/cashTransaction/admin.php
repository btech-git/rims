<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs=array(
	'Cash Transactions'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List CashTransaction', 'url'=>array('index')),
	array('label'=>'Create CashTransaction', 'url'=>array('create')),
);*/

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
	$('#cash-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Cash Transactions</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
				<?php echo CHtml::link('<span class="fa fa-plus"></span>New Cash Transaction', Yii::app()->baseUrl.'/transaction/cashTransaction/create', array('class'=>'button success right', 'visible'=>Yii::app()->user->checkAccess("transaction.cashTransaction.create"))) ?>
				<h2>Manage Cash Transactions</h2>
			</div>

			<div class="search-bar">
				<div class="clearfix button-bar">
		  			<!--<div class="left clearfix bulk-action">
		         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
		         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
		         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
		         	</div>-->
					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>					<div class="clearfix"></div>
					<div class="search-form" style="display:none">
					<?php $this->renderPartial('_search',array(
						'model'=>$model,
					)); ?>
					</div><!-- search-form -->
		        </div>
		    </div>
        	
        	<div class="grid-view">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'cash-transaction-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText'=>'',
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'columns'=>array(
						//'id',
						//'transaction_number',
						array('name'=>'transaction_number', 'value'=>'CHTml::link($data->transaction_number, array("view", "id"=>$data->id))', 'type'=>'raw'),
						'transaction_date',
						'transaction_type',
						//'coa_id',
						array('name'=>'coa_name','value'=>'$data->coa!=""?$data->coa->name:""'),
						'debit_amount',
						'credit_amount',
						'status',
						//'branch_id',
						array('name'=>'branch_id','value'=>'$data->branch!=""?$data->branch->name:""'),
//						array('name'=>'user_id','value'=>'$data->user!=""?$data->user->username:""'),
						//'user_id',

						array(
								'class'=>'CButtonColumn',
								'template'=>'{edit}',
								'buttons'=>array
								(
									'edit' => array
									(
										'label'=>'edit',
										'url'=>'Yii::app()->createUrl("transaction/cashTransaction/update", array("id"=>$data->id))',
										'visible'=>'$data->status != "Approved" && $data->status != "Rejected" && Yii::app()->user->checkAccess("transaction.cashTransaction.update")',
										
										),
									),
								),
							),
							)); ?>
			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->
