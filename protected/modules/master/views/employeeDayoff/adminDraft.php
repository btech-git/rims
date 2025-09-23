<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */

$this->breadcrumbs = array(
    'Employee Dayoffs' => array('index'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List EmployeeDayoff', 'url'=>array('index')),
  array('label'=>'Create EmployeeDayoff', 'url'=>array('create')),
  ); */

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
	$('#employee-dayoff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Employee Dayoffs</h1>-->


<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/EmployeeDayoff/create'; ?>">
                    <span class="fa fa-plus"></span>Create Pengajuan Cuti Karyawan
                </a>
                <h2>Draft Pengajuan Cuti Karyawan</h2>
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
                    'id' => 'employee-dayoff-grid',
                    'dataProvider' => $modelDraftDataprovider,
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name'=>'transaction_number', 
                            'value'=>'CHtml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                            'type'=>'raw'
                        ),
                        'date_created',
                        array('name' => 'employee_id', 'value' => '$data->employee->name'),
                        array(
                            'header'=>'Paid/Unpaid', 
                            'name'=>'off_type',
                            'value'=>'$data->off_type',
                            'type'=>'raw',
                            'filter'=>CHtml::activeDropDownList($model, 'off_type', array(
                                ''=>'All',
                                'Paid' => 'Paid',
                                'Unpaid' => 'Unpaid',
                            )),
                        ),
                        'day',
                        'notes',
                        'date_from',
                        'date_to',
                        array(
                            'name'=>'status',
                            'value'=>'$data->status',
                            'type'=>'raw',
                            'filter' => false,
                        ),
                        'user.username',
//                        array(
//                            'class' => 'CButtonColumn',
//                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
