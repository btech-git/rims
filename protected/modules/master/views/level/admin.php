<?php
/* @var $this LevelController */
/* @var $model Level */

$this->breadcrumbs=array(
	'Company',
	'Levels'=>array('admin'),
	'Manage Levels',
	);

$this->menu=array(
	array('label'=>'List Level', 'url'=>array('index')),
	array('label'=>'Create Level', 'url'=>array('create')),
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
		$('#level-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});

	//Create dialog
	$('#create-button').click(function(){
		$.ajax({
			type: 'POST',
			url: '" . CController::createUrl('ajaxHtmlCreate') . "',
			data: $('form').serialize(),
			success: function(html) {
				$('#level-dialog').dialog('open');
				$('#level_div').html(html);
			},
		});
	});
	");

	?>
	<div id="maincontent">
		<div class="clearfix page-action">
		<?php if (Yii::app()->user->checkAccess("master.level.create")) { ?>

			<!--<a class="button success right" "id" ="create-button" href="<?php echo Yii::app()->baseUrl.'/master/level/create';?>" onclick='$("#mydialog").dialog("open"); return false;'><span class="fa fa-plus"></span>New Level</a>-->


			<?php echo CHtml::button('New Level', array('id' => 'create-button', 'class'=>'button success right')); ?>
            <?php }?>

				<?php // the link that may open the dialog
					/*echo CHtml::link('New Level', '#', array(
					'onclick'=>'$("#mydialog").dialog("open"); return false;',
					));*/ ?>

					<h1>Manage Levels</h1>
					<!-- begin pop up -->
					<div id="employee" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<div class="small-12 columns">
							<div id="maincontent">
								<div class="clearfix page-action">
									<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/level/create';?>"><span class="fa fa-th-list"></span>Manage Levels</a>
									<h1>New Level</h1>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end pop up -->

				<div class="search-bar">
					<div class="clearfix button-bar">
			<!--<div class="left clearfix bulk-action">
     		<span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
     		<input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
     		<input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
     	</div>-->
     	<a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
     	<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button right button cbutton secondary')); ?>
     </div>
     <div class="clearfix"></div>
     <div class="search-form" style="display:none">
     	<?php $this->renderPartial('_search',array(
     		'model'=>$model,
     		)); ?>
     	</div><!-- search-form -->
     </div>	

     <div class="grid-view">
     	<!-- Test Dialog -->
     	<?php $this->widget('zii.widgets.grid.CGridView', array(
     		'id'=>'level-grid',
     		'dataProvider'=>$model->search(),
     		'filter'=>$model,
			// 'summaryText' => '',
     		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
     		'pager'=>array(
     			'cssFile'=>false,
     			'header'=>'',
     			),
               'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
               'columns'=>array(
                 array (
                     'class' 		 => 'CCheckBoxColumn',
                     'selectableRows' => '2',	
                     'header'		 => 'Selected',	
                     'value' => '$data->id',				
                     ),
                 array('name'=>'name', 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type'=>'raw'),
                 array(
                     'header'=>'Status',
                     'name'=>'status',
                     'value'=>'$data->status',
                     'type'=>'raw',
                     'filter'=>CHtml::dropDownList('Level[status]', $model->status, 
                         array(
                             ''=>'All',
                             'Active' => 'Active',
                             'Inactive' => 'Inactive',
                             )
                         ),
                     ),
                 array(
                     'class'=>'CButtonColumn',
                     'template'=>'{edit} {hapus} {restore}',
					// 'deleteConfirmation'=>"js:'Record with ID '+$(this).parent().parent().children(':first-child').text()+' will be deleted! Continue?'",
                     'buttons'=>array(
                         'edit' => array(
                             'label' => 'edit',
                              // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                              'visible'=>'(Yii::app()->user->checkAccess("master.level.update"))',
                             'url' => 'Yii::app()->createUrl("/master/level/ajaxHtmlUpdate", array("id" => $data->id))',
                             'options' => array(  
                                'ajax' => array(
                                    'type' => 'POST',
									// ajax post will use 'url' specified above 
                                    'url' => 'js: $(this).attr("href")',
                                    'success' => 'function(html) {
                                        $("#level_div").html(html);
                                        $("#level-dialog").dialog("open");
                                   }',
                                   ),
                                ),
                             ),
                         'hapus' => array(
                             'label' => 'Delete',
                              'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                             'url' => 'Yii::app()->createUrl("/master/level/delete", array("id" => $data->id))',
                             'options'=>array(
     							// 'class'=>'btn red delete',
                                 'onclick' => 'return confirm("Are you sure want to delete this level?");',
                                 )
                             ),
                     'restore' => array(
                         'label' => 'UNDELETE',
                         'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
                         'url' => 'Yii::app()->createUrl("master/level/restore", array("id" => $data->id))',
                         'options'=>array(
                                                  // 'class'=>'btn red delete',
                              'onclick' => 'return confirm("Are you sure want to undelete this Company?");',
                              )
                         ),

                         ),
                     ),
                 ),
                 )); ?>


            </div>
       </div>

       <!--Level Dialog -->
       <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'level-dialog',
        'options'=>array(
            'title'=>'Level',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>'450',
            ),
            )); ?>

            <div id="level_div"></div>
            <?php $this->endWidget(); ?>