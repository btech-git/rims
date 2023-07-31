<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Company',
    'Employees' => array('admin'),
    'Manage Employees',
);

$this->menu = array(
    array('label' => 'List Employee', 'url' => array('index')),
    array('label' => 'Create Employee', 'url' => array('create')),
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
	$('#employee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button primary right" href="<?php echo Yii::app()->baseUrl . '/master/employee/admin'; ?>">
            Manage Employees
        </a>
        <h1>Resigned Employees</h1>

        <!-- BEGIN aSearch -->
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
                'id' => 'employee-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'name' => 'id',
                        'type' => 'raw',
                        'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
                    ),
                    array(
                        'name' => 'username',
                        'type' => 'raw',
                        'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
                    ),
                    'create_at',
                    'employee.name',
                    array(
                        'name' => 'status',
                        'value' => 'User::itemAlias("UserStatus",$data->status)',
                        'filter' => User::itemAlias("UserStatus"),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>