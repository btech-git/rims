<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs = array(
    'Company',
    'Divisions' => array('admin'),
    'Manage Divisions',
);

$this->menu = array(
    array('label' => 'List Division', 'url' => array('index')),
    array('label' => 'Create Division', 'url' => array('create')),
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

$('.search-form form').submit(function(){
    $('#division-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterDivisionCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/division/create'; ?>"><span class="fa fa-plus"></span>New Division</a>
        <?php } ?>
        <h1>Manage Divisions</h1>
    </div>
    <!-- end pop up -->

    <div class="search-bar">
        <div class="clearfix button-bar">
            <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div><!-- search-form -->
        </div>
    </div>

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'division-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            // 'summaryText' => '',
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '2',
                    'header' => 'Selected',
                    'value' => '$data->id',
                ),
                array(
                    'name' => 'name', 
                    'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 
                    'type' => 'raw'
                ),
                array(
                    'header' => 'Status',
                    'name' => 'status',
                    'value' => '$data->status',
                    'type' => 'raw',
                    'filter' => CHtml::dropDownList('Division[status]', $model->status, array(
                        '' => 'All',
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                    )),
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit} {hapus} {restore}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => 'edit',
                            // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                            'visible' => '(Yii::app()->user->checkAccess("master.division.update"))',
                            'url' => 'Yii::app()->createUrl("master/division/update",array("id"=>$data->id))',
                        ),
                        'hapus' => array(
                            'label' => 'delete',
                            'visible' => '($data->is_deleted == 0)? TRUE:FALSE',
                            'url' => 'Yii::app()->createUrl("master/division/delete", array("id" => $data->id))',
                            'options' => array(
                                // 'class'=>'btn red delete',
                                'onclick' => 'return confirm("Are you sure want to delete this Division?");',
                            )
                        ),
                        'restore' => array(
                            'label' => 'UNDELETE',
                            'visible' => '($data->is_deleted == 1)? TRUE:FALSE',
                            'url' => 'Yii::app()->createUrl("master/division/restore", array("id" => $data->id))',
                            'options' => array(
                                // 'class'=>'btn red delete',
                                'onclick' => 'return confirm("Are you sure want to undelete this Division?");',
                            )
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>