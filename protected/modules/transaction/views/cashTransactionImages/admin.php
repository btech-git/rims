<?php
/* @var $this CashTransactionImagesController */
/* @var $model CashTransactionImages */

$this->breadcrumbs=array(
	'Cash Transaction Images'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List CashTransactionImages', 'url'=>array('index')),
	array('label'=>'Create CashTransactionImages', 'url'=>array('create')),
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
	$('#cash-transaction-images-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Cash Transaction Images</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
				<a class="button success right" href="#"><span class="fa fa-plus"></span>Create Cash Transaction Images</a>
				<h2>Manage Cash Transaction Images</h2>
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
					'id'=>'cash-transaction-images-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					// 'summaryText'=>'',
					'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
					'pager'=>array(
					   'cssFile'=>false,
					   'header'=>'',
					),
					'columns'=>array(
						'id',
		'cash_transaction_id',
		'extension',
		'is_inactive',
						array(
							'class'=>'CButtonColumn',
						),
					),
				)); ?>
			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->
