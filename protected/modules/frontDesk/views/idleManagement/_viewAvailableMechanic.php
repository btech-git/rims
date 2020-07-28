<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'employee-grid',
    'dataProvider'=>$employeeDataProvider,
    'filter'=>$employee,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'header' => 'Name',
            'value' => 'CHtml::link($data->employee->name, array("/frontDesk/idleManagement/viewEmployeeDetail", "employeeId"=>$data->employee_id), array("target" => "_blank"))',
            'type'=>'raw',
        ),
        'employee.id_card: ID #',
        'division.name: Division',
        'position.name: Position',
        'level.name: Level',
        array(
            'name'=>'branch_id', 
            'filter' => CHtml::activeDropDownlist($employee, 'branch_id', CHtml::listData(Branch::model()->findAll(),'id','code'), array('empty' => '--All--')),
            'value'=>'$data->branch->name'
        ),
    ),
)); ?>