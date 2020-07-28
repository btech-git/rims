<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Manage'),
	);
$this->menu=array(
	array('label'=>UserModule::t('Create Profile Field'), 'url'=>array('create')),
	array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
	array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
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
		$.fn.yiiGridView.update('profile-field-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	");

	?>
	<!-- <h1>Manage Banks</h1> -->
	<div id="maincontent">
		<div class="row">
			<div class="small-12 columns">
				<div class="clearfix page-action">
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/user/profileField/create';?>"><span class="fa fa-plus"></span>New Profile Field</a>
					<h2>Manage Users</h2>

					<div class="search-bar">
						<div class="clearfix button-bar">
				  			<!--<div class="left clearfix bulk-action">
				         		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
				         		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
				         		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
				         	</div>-->

				         	<?php echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button right button cbutton secondary')); ?>
				         	<div class="clearfix"></div>
				         	<div class="search-form" style="display:none">
				         		<?php $this->renderPartial('_search',array(
				         			'model'=>$model,
				         			)
				         		); 
				         		?>
				         	</div><!-- search-form -->
				         </div>
				     </div>

				     <div class="grid-view">
				     	<?php $this->widget('zii.widgets.grid.CGridView', array(
				     		'dataProvider'=>$model->search(),
				     		'filter'=>$model,
				     		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
				     		'pager'=>array(
				     			'cssFile'=>false,
				     			'header'=>'',
				     			),
				     		'columns'=>array(
				     			'id',
				     			array('name'=>'varname',
				     				'type'=>'raw',
				     				'value'=>'UHtml::markSearch($data,"varname")',
				     				),
				     			array('name'=>'title',
				     				'value'=>'UserModule::t($data->title)',
				     				),
				     			array('name'=>'field_type',
				     				'value'=>'$data->field_type',
				     				'filter'=>ProfileField::itemAlias("field_type"),
				     				),
				     			'field_size',
								//'field_size_min',
				     			array('name'=>'required',
				     				'value'=>'ProfileField::itemAlias("required",$data->required)',
				     				'filter'=>ProfileField::itemAlias("required"),
				     				),
								//'match',
								//'range',
								//'error_message',
								//'other_validator',
								//'default',
				     			'position',
				     			array('name'=>'visible',
				     				'value'=>'ProfileField::itemAlias("visible",$data->visible)',
				     				'filter'=>ProfileField::itemAlias("visible"),
				     				),
				     			array('class'=>'CButtonColumn',
				     				'template'=>'{edit}',
				     				'buttons'=>array(
				     					'edit'=> array (
				     						'label'=>'edit',
				     						'url' =>'Yii::app()->createUrl("user/profileField/update",array("id"=>$data->id))',
				     						),
				     					),
				     				),
				     			),
				     		)
				     	); 
				     	?>
				     </div>


				 </div>
				</div>

				<!-- end maincontent -->
			</div>
