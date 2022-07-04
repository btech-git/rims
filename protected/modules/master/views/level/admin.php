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
        
        if ($(this).hasClass('active')) {
                $(this).text('');
        } else {
                $(this).text('Advanced Search');
        }
        
        return false;
    });
    
    $('.search-form form').submit(function() {
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
        <?php if (Yii::app()->user->checkAccess("masterLevelCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/level/create'; ?>"><span class="fa fa-plus"></span>New Level</a>
        <?php }?>
        <h1>Manage Levels</h1>
    </div>

    <div class="search-bar">
        <div class="clearfix button-bar">
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
                 'class' => 'CCheckBoxColumn',
                 'selectableRows' => '2',	
                 'header' => 'Selected',	
                 'value' => '$data->id',				
                 ),
             array(
                 'name'=>'name', 
                 'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 
                 'type'=>'raw'
             ),
             array(
                 'header'=>'Status',
                 'name'=>'status',
                 'value'=>'$data->status',
                 'type'=>'raw',
                 'filter'=>CHtml::dropDownList('Level[status]', $model->status, array(
                     ''=>'All',
                     'Active' => 'Active',
                     'Inactive' => 'Inactive',
                 )),
             ),
             array(
                 'class'=>'CButtonColumn',
                 'template'=>'{edit} {hapus} {restore}',
                 'buttons'=>array(
                    'edit' => array(
                        'label' => 'edit',
                        'visible'=>'(Yii::app()->user->checkAccess("masterLevelEdit"))',
                        'url' => 'Yii::app()->createUrl("/master/level/ajaxHtmlUpdate", array("id" => $data->id))',
                        'options' => array(  
                            'ajax' => array(
                                'type' => 'POST',
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
                             'onclick' => 'return confirm("Are you sure want to delete this level?");',
                             )
                         ),
                 'restore' => array(
                     'label' => 'UNDELETE',
                     'visible'=>'($data->is_deleted == 1)? TRUE:FALSE',
                     'url' => 'Yii::app()->createUrl("master/level/restore", array("id" => $data->id))',
                     'options'=>array(
                          'onclick' => 'return confirm("Are you sure want to undelete this Company?");',
                          )
                     ),

                     ),
                 ),
             ),
         )); ?>
    </div>
</div>