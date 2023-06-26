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



<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */
?>

<!-- BEGIN maincontent -->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterEmployeeCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/employee/create'; ?>"><span class="fa fa-plus"></span>New Employee</a>
        <?php } ?>
        <h1>Manage Employees</h1>


        <!-- BEGIN aSearch -->
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
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div><!-- search-form -->
        </div>
        <!-- END aSearch -->		


        <!-- BEGIN gridview -->
        <div class="grid-view">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'employee-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                // 'summaryText' => '',
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
                        'name' => 'recruitment_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->recruitment_date)'
                    ),
                    array(
                        'name' => 'name', 
                        'value' => 'CHtml::link($data->name, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'branch_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "branch.name"))',
                    ),
                    array(
                        'name' => 'division_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "division.name"))',
                    ),
                    array(
                        'name' => 'position_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "position.name"))',
                    ),
                    array(
                        'name' => 'level_id', 
                        'value' => 'CHtml::encode(CHtml::value($data, "level.name"))',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit} {hapus} {restore}',
                        'buttons' => array
                            (
                            'edit' => array
                                (
                                'label' => 'edit',
                                // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                                'visible' => '(Yii::app()->user->checkAccess("master.employee.update"))',
                                'url' => 'Yii::app()->createUrl("master/employee/update", array("id"=>$data->id))',
                            ),
                            'hapus' => array(
                                'label' => 'delete',
                                'visible' => '($data->is_deleted == 0)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("/master/employee/delete", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to delete this Employee?");',
                                )
                            ),
                            'restore' => array(
                                'label' => 'UNDELETE',
                                'visible' => '($data->is_deleted == 1)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("master/employee/restore", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to undelete this Employee?");',
                                )
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
        <!-- END gridview -->



    </div>
    <!-- END maincontent -->		

</div>


