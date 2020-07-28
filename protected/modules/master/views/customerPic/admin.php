<?php
/* @var $this CustomerPicController */
/* @var $model CustomerPic */

$this->breadcrumbs=array(
	'Customer Pics'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CustomerPic', 'url'=>array('index')),
	array('label'=>'Create CustomerPic', 'url'=>array('create')),
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
	$('#customer-pic-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="#">Home</a>
			<a href="#">Company</a>
			<a href="#">Customer Pic</a>				
			<span>Manage Customer Pics</span>
		</div>
	</div>
</div>

	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.customerPic.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/customerPic/create';?>"><span class="fa fa-plus"></span>New Customer Pic</a>
<?php }?>
				<h1>Manage Customer Pics</h1>
	<div class="search-bar">
		<div class="clearfix button-bar">
			<!--<div class="left clearfix bulk-action">
      		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
      		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
      		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
			<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>   
		</div>

		<div class="clearfix"></div>
<div class="search-form" style="display:none">
		<?php $this->renderPartial('_search',array(
			'model'=>$model,
		)); ?>
		</div><!-- search-form -->
	</div>
			
			<div class="grid-view">

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'customer-pic-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	// 'summaryText' => '',
	'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
	'pager'=>array(
	   'cssFile'=>false,
	   'header'=>'',
	),
					'columns'=>array(
						array (
							'class' 		 => 'CCheckBoxColumn',
							'selectableRows' => '2',	
							'header'		 => 'Selected',	
							'value' => '$data->id',				
							),
		'customer_id',
		'name',
		'address',
		'city',
		'zipcode',
		/*
		'phone',
		'mobile_phone',
		'fax',
		'email',
		'note',
		'customer_type',
		'status',
		'birthdate',
		*/
		array(
							'class'=>'CButtonColumn',
							'template'=>'{edit}',
							'buttons'=>array
							(
								'edit' => array
								(
									'label'=>'edit',
									'url'=>'Yii::app()->createUrl("master/customerPic/update", array("id"=>$data->id))',
									'visible'=>'(Yii::app()->user->checkAccess("master.customerPic.update"))',
								),
							),
						),
					),
				)); ?>
				</div>
			</div>
			<!-- end maincontent -->
		</div>