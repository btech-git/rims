<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */

$this->breadcrumbs=array(
	'Invoice Details'=>array('admin'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List InvoiceDetail', 'url'=>array('index')),
	array('label'=>'Create InvoiceDetail', 'url'=>array('create')),
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
	$('#invoice-detail-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Invoice Details</h1>-->


<div id="maincontent">
	<div class="row">
		<div class="small-12 columns">
			<div class="clearfix page-action">
				<a class="button success right" href="#"><span class="fa fa-plus"></span>Create Invoice Details</a>
				<h2>Manage Invoice Details</h2>
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
					'id'=>'invoice-detail-grid',
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
		'invoice_id',
		'service_id',
		'product_id',
		'quantity',
		'unit_price',
		/*
		'total_price',
		*/
						array(
							'class'=>'CButtonColumn',
						),
					),
				)); ?>
			</div>
		</div>
	</div> <!-- end row -->
</div> <!-- end maintenance -->
