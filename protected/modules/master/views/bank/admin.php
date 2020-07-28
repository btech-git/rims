<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
	'Accounting',
	'Banks'=>array('admin'),
	'Manage Banks',
	);

// $this->menu=array(
// 	array('label'=>'List Bank', 'url'=>array('index')),
// 	array('label'=>'Create Bank', 'url'=>array('create')),
// );

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
		$('#bank-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
// Yii::app()->clientScript->registerScript('search', "
// $('.search-button').click(function(){
// 	$('.search-form').slideToggle(600);
// 	$('.bulk-action').toggle();
// 	$(this).toggleClass('active');
// 	// if($(this).hasClass('active')){
// 		$(this).text('');
// 	}else {
// 		$(this).text('Advanced Search');
// 	}
// 	return false;
// });
// $('.search-form form').submit(function(){
// 	$('#bank-grid').yiiGridView('update', {
// 		data: $(this).serialize()
// 	});
// 	return false;
// });
// ");
	?>

	<!-- <h1>Manage Banks</h1> -->
	<div id="maincontent">
		<div class="row">
			<div class="small-12 columns">
				<div class="clearfix page-action">
				<?php if (Yii::app()->user->checkAccess("master.bank.create")) { ?>
					<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/bank/create';?>"><span class="fa fa-plus"></span>New Bank</a>
					<?php } ?>
					<h2>Manage Bank</h2>
				</div>

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
			         		'id'=>'bank-grid',
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
			         			array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw', 'filterHtmlOptions' =>array('class'=>'adaloh')),
			         			'code',
                                'coa.name: COA',
			         			array(
			         				'class'=>'CButtonColumn',
			         				'template'=>'{edit}',
			         				'buttons'=>array
			         				(
			         					'edit'=> array (
			         						'label'=>'edit',
			         						'url' =>'Yii::app()->createUrl("master/bank/update",array("id"=>$data->id))',
											'visible'=>'(Yii::app()->user->checkAccess("master.bank.admin"))',
			         						),
			         					),
			         				),
			         			),
			         			)); ?>
			         		</div>


			         	</div>
			         </div>

			         <!-- end maincontent -->
			     </div>
