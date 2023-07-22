<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */

$this->breadcrumbs = array(
    'Public Day Offs' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    if ($(this).hasClass('active')){
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    return false;
});

$('.search-form form').submit(function(){
    $('#public-day-off-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/publicDayOff/create'; ?>"><span class="fa fa-plus"></span>Create Libur Nasional</a>
                <h2>Manage Hari Libur Nasional</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					<div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'public-day-off-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        'id',
                        'date',
                        'type',
                        'description',
                        array(
                            'class' => 'CButtonColumn',
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
