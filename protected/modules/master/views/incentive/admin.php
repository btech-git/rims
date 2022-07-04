<?php
/* @var $this IncentiveController */
/* @var $model Incentive */

$this->breadcrumbs = array(
    'Company',
    'Incentives' => array('admin'),
    'Manage Incentives',
);

$this->menu = array(
    array('label' => 'List Incentive', 'url' => array('index')),
    array('label' => 'Create Incentive', 'url' => array('create')),
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
    $('#incentive-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterIncentiveCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/incentive/create'; ?>"><span class="fa fa-plus"></span>New Incentive</a>
        <?php } ?>
        <h1>Manage Incentives</h1>
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
            'id' => 'incentive-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
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
                'description',
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit} {hapus} {restore}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => 'edit',
                            // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                            'visible' => '(Yii::app()->user->checkAccess("masterIncentiveEdit"))',
                            'url' => 'Yii::app()->createUrl("master/incentive/update",array("id"=>$data->id))',
                        ),
                        'hapus' => array(
                            'label' => 'delete',
                            'visible' => '($data->is_deleted == 0)? TRUE:FALSE',
                            'url' => 'Yii::app()->createUrl("master/incentive/delete", array("id" => $data->id))',
                            'options' => array(
                                // 'class'=>'btn red delete',
                                'onclick' => 'return confirm("Are you sure want to delete this Incentive?");',
                            )
                        ),
                        'restore' => array(
                            'label' => 'UNDELETE',
                            'visible' => '($data->is_deleted == 1)? TRUE:FALSE',
                            'url' => 'Yii::app()->createUrl("master/incentive/restore", array("id" => $data->id))',
                            'options' => array(
                                // 'class'=>'btn red delete',
                                'onclick' => 'return confirm("Are you sure want to undelete this Incentive?");',
                            )
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>
