<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */

$this->breadcrumbs=array(
	'Employee Exchange Dayoffs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List EmployeeExchangeDayoff', 'url'=>array('index')),
	array('label'=>'Create EmployeeExchangeDayoff', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#employee-exchange-dayoff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/employeeExchangeDayoff/create'; ?>">
            <span class="fa fa-plus"></span>New
        </a>

        <h1>Manage Tukar Hari Libur Employee</h1>

        <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
        </p>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
            </div>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div><!-- search-form -->
        </div>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'employee-exchange-dayoff-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'columns' => array(
                    'id',
                    'date_dayoff_old',
                    'date_dayoff_new',
                    'employee.name',
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>