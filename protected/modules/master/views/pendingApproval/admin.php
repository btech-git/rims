<?php
/* @var $this ServiceStandardPricelistController */
/* @var $model ServiceStandardPricelist */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Standard Pricelists'=>array('admin'),
	'Manage',
);

$this->menu=array(
	// array('label'=>'List ServiceStandardPricelist', 'url'=>array('index')),
	// array('label'=>'Create ServiceStandardPricelist', 'url'=>array('create')),
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
$('form').submit(function(){
	$('#service-standard-pricelist-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


	
			<div id="maincontent">
				<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.serviceStandardPricelist.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/serviceStandardPricelist/create';?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Service Standard Pricelist</a>
			<?php }?>
					<h1>Manage Service Standard Pricelist</h1>

					<div class="search-bar">
				<div class="clearfix button-bar">
      			<!--<div class="left clearfix bulk-action">
	         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
	         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
	         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
         		</div>-->
<div class="row">
							<div class="medium-12 columns">
							<?php $form=$this->beginWidget('CActiveForm', array(
								'action'=>Yii::app()->createUrl($this->route),
								'method'=>'get',
								)); ?>
								  <div class="row">
	    							<div class="medium-3 columns">
					       				<?php echo $form->textField($model,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
					       			</div>
	    							<div class="medium-3 columns">
					       				<?php echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'name'),
											array(
						               		'prompt' => '[--Select Service--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							<div class="medium-3 columns">
					       				<?php echo $form->dropDownList($model, 'service_type_code', CHtml::listData(ServiceType::model()->findAll(), 'name', 'name'),
											array(
						               		'prompt' => '[--Select Service Type--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							<div class="medium-3 columns">
					       				<?php echo $form->dropDownList($model, 'service_category_code', CHtml::listData(ServiceCategory::model()->findAll(), 'name', 'name'),
											array(
						               		'prompt' => '[--Select Service Category--]',"style"=>"margin-bottom:0px;"
						          			)
						          		);?>
					       			</div>
	    							
						          </div>
								<?php $this->endWidget(); ?>
							</div>
							<?php /*<div class="medium-2 columns">
								<a href="#" class="search-button right button cbutton secondary" id="advsearch" style="display: none;">Advanced Search</a>	
							</div>*/?>
						</div>   
      			<?php /*<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
				<div class="clearfix"></div>
				<div class="search-form" style="display:none">
				<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
				</div><!-- search-form -->*/
				?>				
      		</div>
      		</div>

				<div class="grid-view">

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'service-standard-pricelist-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
						'pager'=>array(
						   'cssFile'=>false,
						   'header'=>'',
						),
						'columns'=>array(
							// 'id',
							// 'service_id',
							array('name'=>'service_type_code','value'=>'$data->service->serviceType->name'),
							array('name'=>'service_category_code','value'=>'$data->service->serviceCategory->name'),
							array('name'=>'service_name','value'=>'CHTml::link($data->service->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
							array('name'=>'service_code','value'=>'$data->service->code'),
							'difficulty',
							'difficulty_value',
							'regular',
							'luxury',
							/*
							'luxury_value',
							'luxury_calc',
							'standard_rate_per_hour',
							'flat_rate_hour',
							'price',
							'common_price',
							*/
							array(
							'class'=>'CButtonColumn',
							'template'=>'{edit}',
							'buttons'=>array
							(
								'edit'=> array (
									'label'=>'edit',
									'visible'=>'(Yii::app()->user->checkAccess("master.serviceStandardPricelist.update"))',
									'url' =>'Yii::app()->createUrl("master/serviceStandardPricelist/update",array("id"=>$data->id))',
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

<?php 
  Yii::app()->clientScript->registerScript('search',"

    	$('#ServiceStandardPricelist_findkeyword').keypress(function(e) {
		    if(e.which == 13) {
				$.fn.yiiGridView.update('service-standard-pricelist-grid', {
					data: $(this).serialize()
				});
		        return false;
		    }
		});

        $('#ServiceStandardPricelist_service_id, #ServiceStandardPricelist_service_type_code, #ServiceStandardPricelist_service_category_code').change(function(){
            $.fn.yiiGridView.update('service-standard-pricelist-grid', {
                data: $(this).serialize()
            });
            return false;
        });

		
    ");
?>
