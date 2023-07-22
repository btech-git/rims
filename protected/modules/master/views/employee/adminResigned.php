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
        <?php if (Yii::app()->user->checkAccess("masterEmployeeCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/employee/create'; ?>"><span class="fa fa-plus"></span>New Employee</a>
        <?php } ?>
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . 'admin'; ?>"><span></span>Manage Employees</a>
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
                'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '2',
                        'header' => 'Selected',
                        'value' => '$data->id',
                    ),
                    'id',
                    'code',
                    array(
                        'name' => 'name', 
                        'value' => 'CHtml::link($data->name, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    array(
                        'header' => 'Resign Date',
                        'name' => 'deleted_at',
                        'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->deleted_at)'
                    ),
                    array(
                        'header' => 'KTP',
                        'name' => 'id_card', 
                        'value' => 'CHtml::encode(CHtml::value($data, "id_card"))',
                    ),
                    array(
                        'header' => 'SIM',
                        'name' => 'driving_license', 
                        'value' => 'CHtml::encode(CHtml::value($data, "driving_license"))',
                    ),
                    array(
                        'header' => 'HP',
                        'name' => 'mobile_phone_number', 
                        'value' => 'CHtml::encode(CHtml::value($data, "mobile_phone_number"))',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>