<?php
/* @var $this GeneralStandardFrController */
/* @var $model GeneralStandardFr */

$this->breadcrumbs=array(
	'General Standard Frs'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List GeneralStandardFr', 'url'=>array('index')),
	array('label'=>'Create GeneralStandardFr', 'url'=>array('create')),
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
	$('#general-standard-fr-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

	
			<div id="maincontent">
				<div class="clearfix page-action">
					<!-- <a class="button success right" href="<?php //echo Yii::app()->baseUrl.'/master/service/create';?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Service</a> -->
					<h1>Manage Standard Flat Rate</h1>

					<div class="search-bar">
				<div class="clearfix button-bar">
      			<!--<div class="left clearfix bulk-action">
	         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
	         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
	         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
      			<!-- <a href="#" class="search-button right button cbutton secondary">Advanced Search</a> -->
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
						'id'=>'general-standard-fr-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							//'id',
							'flat_rate',
							array(
							'class'=>'CButtonColumn',
							'template'=>'{edit}',
							'buttons'=>array
							(
								'edit'=> array (
									'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.generalStandardFr.update"))',
									'url' =>'Yii::app()->createUrl("master/generalStandardFr/update",array("id"=>$data->id))',
								),
							),
						),
					),
				)); ?>

				</div>
		</div>
	</div>